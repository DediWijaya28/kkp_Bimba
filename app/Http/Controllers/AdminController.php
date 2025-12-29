<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user')->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%");
                  });
            });
        }

        $students = $query->get();
        $totalStudents = Student::count(); // Keep total count independent of search
        $pendingVerification = Student::where('status', 'paid')->count();
        $activeStudents = Student::where('status', 'active')->count();

        return view('admin.dashboard', compact('students', 'totalStudents', 'pendingVerification', 'activeStudents'));
    }

    public function show(Student $student)
    {
        $student->load(['parent', 'warranty', 'documents', 'user']);
        return view('admin.show', compact('student'));
    }

    /**
     * Resolve a region name by fetching EMSIFA JSON lists.
     */
    protected function resolveRegionName(string $pathSegment, $id)
    {
        try {
            $url = "https://www.emsifa.com/api-wilayah-indonesia/api/{$pathSegment}.json";
            $contents = @file_get_contents($url);
            if (!$contents) return '';
            $data = json_decode($contents, true);
            if (!is_array($data)) return '';
            foreach ($data as $item) {
                if (isset($item['id']) && (string)$item['id'] === (string)$id) {
                    return $item['name'] ?? '';
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }
        return '';
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // User Data
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            
            // Student Data
            'full_name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:255',
            
            // Address Data
            'province_id' => 'required|string',
            'city_id' => 'required|string',
            'district_id' => 'required|string',
            'village_id' => 'required|string',
            'street_address' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'house_number' => 'nullable|string|max:20',
            'postal_code' => 'nullable|string|max:10',
            
            // Parent Data
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_occupation' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_occupation' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            
            // Region Names (hidden inputs)
            'province_name' => 'nullable|string',
            'city_name' => 'nullable|string',
            'district_name' => 'nullable|string',
            'village_name' => 'nullable|string',
        ]);

        // Attempt to resolve names from API if JS failed to populate hidden fields
        try {
            if (empty($validated['province_name']) && !empty($validated['province_id'])) {
                $validated['province_name'] = $this->resolveRegionName('provinces', $validated['province_id']);
            }
            if (empty($validated['city_name']) && !empty($validated['city_id'])) {
                $validated['city_name'] = $this->resolveRegionName("regencies/{$validated['province_id']}", $validated['city_id']);
            }
            if (empty($validated['district_name']) && !empty($validated['district_id'])) {
                $validated['district_name'] = $this->resolveRegionName("districts/{$validated['city_id']}", $validated['district_id']);
            }
            if (empty($validated['village_name']) && !empty($validated['village_id'])) {
                $validated['village_name'] = $this->resolveRegionName("villages/{$validated['district_id']}", $validated['village_id']);
            }
        } catch (\Throwable $e) {}

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            // 1. Create User
            $user = \App\Models\User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'role' => 'user',
            ]);

            // 2. Format Address
            $parts = [$validated['street_address']];
            if (!empty($validated['rt'])) $parts[] = "RT " . $validated['rt'];
            if (!empty($validated['rw'])) $parts[] = "RW " . $validated['rw'];
            if (!empty($validated['house_number'])) $parts[] = "No. " . $validated['house_number'];
            $parts[] = $validated['village_name'];
            $parts[] = $validated['district_name'];
            $parts[] = $validated['city_name'];
            $parts[] = $validated['province_name'];
            if (!empty($validated['postal_code'])) $parts[] = "Kode Pos " . $validated['postal_code'];
            
            $fullAddress = implode(", ", array_filter($parts));

            // 3. Create Student
            $student = Student::create([
                'user_id' => $user->id,
                'full_name' => ucwords(strtolower($validated['full_name'])),
                'nickname' => ucwords(strtolower($validated['nickname'])),
                'birth_place' => ucwords(strtolower($validated['birth_place'])),
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'religion' => $validated['religion'],
                'address' => $fullAddress,
                'province_id' => $validated['province_id'],
                'city_id' => $validated['city_id'],
                'district_id' => $validated['district_id'],
                'village_id' => $validated['village_id'],
                'street_address' => $validated['street_address'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'house_number' => $validated['house_number'],
                'postal_code' => $validated['postal_code'],
                'status' => 'verified', // Admin created, so we assume verified/submitted
            ]);

            // 4. Create Placeholder Payment (so admin can update details later)
            \App\Models\Payment::create([
                'student_id' => $student->id,
                'amount' => 0,
                'payment_method' => 'cash', // Default to cash for manual admin entry
                'status' => 'pending',
                'registration_number' => null, // Will be filled by admin later or generated
            ]);

            // 5. Create Parent
            \App\Models\StudentParent::create([
                'student_id' => $student->id,
                'father_name' => ucwords(strtolower($validated['father_name'])),
                'mother_name' => ucwords(strtolower($validated['mother_name'])),
                'father_occupation' => ucwords(strtolower($validated['father_occupation'])),
                'father_phone' => $validated['father_phone'],
                'mother_occupation' => ucwords(strtolower($validated['mother_occupation'])),
                'phone' => $validated['phone'],
            ]);
        });

        return redirect()->route('admin.dashboard')->with('success', 'Siswa berhasil ditambahkan. Silakan lanjutkan dengan pemilihan kelas jika diperlukan.');
    }

    public function verify(Request $request, Student $student)
    {
        if ($student->status !== 'paid' && $request->status === 'verified') {
            return back()->with('error', 'Siswa harus melakukan pembayaran sebelum dapat diverifikasi.');
        }

        $request->validate([
            'status' => 'required|in:verified,needs_revision',
            'note' => 'nullable|string',
        ]);

        $updateData = ['status' => $request->status];
        
        if ($request->status === 'needs_revision') {
            $updateData['revision_note'] = $request->note;
        }

        $student->update($updateData);

        // Also verify payment if exists
        if ($student->payment && $request->status === 'verified') {
            $student->payment->update([
                'status' => 'verified',
                'verified_at' => now(),
            ]);
        }

        // If rejected, maybe add a note to a specific document or general note?
        // For simplicity, we just update status. Ideally we'd have a 'notes' table or column on student.
        // We can use session flash for now.

        return back()->with('success', 'Status siswa berhasil diperbarui menjadi ' . $request->status);
    }



    public function validatePayment(Request $request, Student $student)
    {
        $request->validate([
            'start_date' => 'required|date',
            'nim' => 'required|string|unique:students,nim,' . $student->id,
        ]);

        $student->update([
            'status' => 'active',
            'start_date' => $request->start_date,
            'nim' => $request->nim,
        ]);
        
        if ($student->payment) {
            $student->payment->update(['status' => 'verified', 'verified_at' => now()]);
        }

        return back()->with('success', 'Pembayaran divalidasi. Siswa kini AKTIF.');
    }

    public function activate(Request $request, Student $student)
    {
        $request->validate([
            'start_date' => 'required|date',
            'nim' => 'required|string|unique:students,nim,' . $student->id,
        ]);

        $student->update([
            'status' => 'active',
            'start_date' => $request->start_date,
            'nim' => $request->nim,
        ]);

        if ($student->payment) {
            $student->payment->update([
                'status' => 'verified',
                'verified_at' => now(),
            ]);
        }

        return back()->with('success', 'Siswa berhasil diaktifkan.');
    }

    public function updatePaymentDetails(Request $request, Student $student)
    {
        $request->validate([
            'registration_number' => 'required|string',
            'registration_fee' => 'required|numeric|min:0',
            'spp_fee' => 'required|numeric|min:0',
            'authorized_signer' => 'nullable|string',
        ]);

        if (!$student->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $student->payment->update([
            'registration_number' => $request->registration_number,
            'registration_fee' => $request->registration_fee,
            'spp_fee' => $request->spp_fee,
            'authorized_signer' => $request->authorized_signer,
        ]);

        return back()->with('success', 'Rincian pembayaran berhasil diperbarui.');
    }

    public function edit(Student $student)
    {
        $student->load('parent');
        return view('admin.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:255',
            'address' => 'required|string',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_occupation' => 'required|string|max:255',
            'mother_occupation' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $student->update([
            'full_name' => $validated['full_name'],
            'nickname' => $validated['nickname'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'religion' => $validated['religion'],
            'address' => $validated['address'],
        ]);

        $student->parent->update([
            'father_name' => $validated['father_name'],
            'mother_name' => $validated['mother_name'],
            'father_occupation' => $validated['father_occupation'],
            'mother_occupation' => $validated['mother_occupation'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('admin.show', $student)->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        // Ideally soft delete, but for now hard delete
        $student->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        // If the user requested to select all across pages, delete all students
        if ($request->boolean('select_all')) {
            $count = Student::count();
            Student::query()->delete();
            return redirect()->route('admin.dashboard')->with('success', $count . ' siswa berhasil dihapus.');
        }

        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:students,id',
        ]);

        $deleted = Student::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.dashboard')->with('success', ($deleted ?: 0) . ' siswa berhasil dihapus.');
    }
    public function exportCsv()
    {
        $students = Student::with('parent')->where('status', 'active')->orderBy('full_name', 'asc')->get();
        $filename = 'laporan-siswa-aktif-' . date('Y-m-d') . '.xls';

        $headers = [
            "Content-type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No', 
            'NIM', 
            'Nama Lengkap', 
            'Tgl Lahir', 
            'Jenis Kelamin', 
            'Agama', 
            'Alamat', 
            'Nama Ayah', 
            'Pekerjaan Ayah',
            'Nomor Telp Ayah', 
            'Nama Ibu', 
            'Pekerjaan Ibu',
            'Nomor Telp Ibu'
        ];

        return response()->stream(function() use($students, $columns) {
            echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            echo '<head>';
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            echo '<!--[if gte mso 9]>';
            echo '<xml>';
            echo '<x:ExcelWorkbook>';
            echo '<x:ExcelWorksheets>';
            echo '<x:ExcelWorksheet>';
            echo '<x:Name>Data Siswa</x:Name>';
            echo '<x:WorksheetOptions>';
            echo '<x:Print>';
            echo '<x:ValidPrinterInfo/>';
            echo '<x:HorizontalResolution>600</x:HorizontalResolution>';
            echo '<x:VerticalResolution>600</x:VerticalResolution>';
            echo '</x:Print>';
            echo '<x:Selected/>';
            echo '<x:Panes>';
            echo '<x:Pane>';
            echo '<x:Number>3</x:Number>';
            echo '<x:ActiveRow>5</x:ActiveRow>';
            echo '</x:Pane>';
            echo '</x:Panes>';
            echo '<x:ProtectContents>False</x:ProtectContents>';
            echo '<x:ProtectObjects>False</x:ProtectObjects>';
            echo '<x:ProtectScenarios>False</x:ProtectScenarios>';
            echo '</x:WorksheetOptions>';
            echo '</x:ExcelWorksheet>';
            echo '</x:ExcelWorksheets>';
            echo '</x:ExcelWorkbook>';
            echo '</xml>';
            echo '<![endif]-->';
            echo '<style>';
            echo '@page { mso-page-orientation: landscape; }';
            echo 'td, th { vertical-align: middle; padding: 5px; }';
            echo '</style>';
            echo '</head><body>';
            
            echo '<table border="1" style="border-collapse: collapse; width: 100%;">';
            
            // Report Header Rows (Clean, No Border, No Color)
            echo '<tr><td colspan="' . count($columns) . '" style="border: none; font-size: 20px; font-weight: bold; text-align: center; vertical-align: middle; height: 40px;">bimba AIUEO Unit Klender</td></tr>';
            echo '<tr><td colspan="' . count($columns) . '" style="border: none; text-align: center; vertical-align: middle;">Jl. Delima Raya No.99 RT.06 RW.05 Kel.Malaka Sari, Kec.Duren Sawit, Jakarta Timur</td></tr>';
            echo '<tr><td colspan="' . count($columns) . '" style="border: none; text-align: center; vertical-align: middle; font-weight: bold;">Laporan Data Siswa Aktif</td></tr>';
            echo '<tr><td colspan="' . count($columns) . '" style="border: none; text-align: center; vertical-align: middle;">Per Tanggal: ' . date('d F Y') . '</td></tr>';
            echo '<tr><td colspan="' . count($columns) . '" style="border: none; height: 10px;"></td></tr>'; // Spacer row

            
            // Table Header (Blue)
            echo '<thead><tr>';
            foreach ($columns as $col) {
                echo '<th style="background-color: #BDD7EE; border: 1px solid #000; text-align: center; vertical-align: middle; font-weight: bold;">' . $col . '</th>';
            }
            echo '</tr></thead>';

            // Body
            echo '<tbody>';
            foreach ($students as $index => $student) {
                echo '<tr>';
                echo '<td style="border: 1px solid #000; text-align: center;">' . ($index + 1) . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->nim ?? '-') . '</td>';
                echo '<td style="border: 1px solid #000; text-transform: uppercase;">' . $student->full_name . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->birth_date ? $student->birth_date->format('d-m-Y') : '-') . '</td>';
                echo '<td style="border: 1px solid #000; text-align: center;">' . $student->gender . '</td>';
                echo '<td style="border: 1px solid #000;">' . $student->religion . '</td>';
                echo '<td style="border: 1px solid #000;">' . $student->address . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->parent->father_name ?? '-') . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->parent->father_occupation ?? '-') . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->parent->father_phone ?? '-') . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->parent->mother_name ?? '-') . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->parent->mother_occupation ?? '-') . '</td>';
                echo '<td style="border: 1px solid #000;">' . ($student->parent->phone ?? '-') . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</body></html>';
        }, 200, $headers);
    }

    public function deleteAll(Request $request)
    {
        // Get all user IDs linked to students
        $studentUserIds = Student::pluck('user_id');

        if ($studentUserIds->isEmpty()) {
            return back()->with('error', 'Tidak ada data pendaftar untuk dihapus.');
        }

        // Delete the users (cascades to students, parents, etc.)
        \App\Models\User::whereIn('id', $studentUserIds)->delete();

        return back()->with('success', 'SEMUA data pendaftar berhasil dihapus.');
    }
}
