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

        return back()->with('success', 'Siswa berhasil diaktifkan.');
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
