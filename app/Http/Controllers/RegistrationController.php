<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Warranty;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function create()
    {
        // Auto-fill parent data from latest student if exists
        $parent = null;
        $user = Auth::user();
        if ($user) {
            // If User model defines students() relation this will work; guard in case null
            // Use Student model query to avoid relying on a User::students relation
            $latestStudent = Student::where('user_id', $user->id)->latest()->first();
            $parent = $latestStudent ? $latestStudent->parent : null;
        }
        
        return view('registration.student_data', ['student' => null, 'parent' => $parent]);
    }

    /**
     * Resolve a region name by fetching EMSIFA JSON lists.
     * pathSegment examples: 'provinces', 'regencies/{provinceId}', 'districts/{cityId}', 'villages/{districtId}'
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

    public function step1(Student $student)
    {
        if ($student->user_id !== Auth::id()) abort(403);
        $parent = $student->parent;
        return view('registration.step1', compact('student', 'parent'));
    }

    public function storeStep1(Request $request)
    {
        $isDraft = $request->input('action') === 'draft';
        
        try {
            $rules = [
                'student_id' => 'nullable|exists:students,id',
                'full_name' => 'required|string|max:255',
                'nickname' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
                'birth_place' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
                'birth_date' => $isDraft ? 'nullable|date' : 'required|date',
                'gender' => $isDraft ? 'nullable|in:L,P' : 'required|in:L,P',
                'religion' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
                // Address fields
                'province_id' => $isDraft ? 'nullable' : 'required|string',
                'city_id' => $isDraft ? 'nullable' : 'required|string',
                'district_id' => $isDraft ? 'nullable' : 'required|string',
                'village_id' => $isDraft ? 'nullable' : 'required|string',
                'street_address' => $isDraft ? 'nullable|string' : 'required|string',
                'rt' => 'nullable|string|max:5',
                'rw' => 'nullable|string|max:5',
                'house_number' => 'nullable|string|max:20',
                'postal_code' => 'nullable|string|max:10',
                // Parent fields
                'father_name' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
                'mother_name' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
                'father_occupation' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
                'father_phone' => $isDraft ? 'nullable|string|max:20' : 'required|string|max:20',
                'mother_occupation' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
                'phone' => $isDraft ? 'nullable|string|max:20' : 'required|string|max:20',
            ];

            // If draft, remove required from dependent fields if not present
            $validated = $request->validate($rules);
            
            // Add non-validated name fields manually if present
            $validated['province_name'] = $request->input('province_name');
            $validated['city_name'] = $request->input('city_name');
            $validated['district_name'] = $request->input('district_name');
            $validated['village_name'] = $request->input('village_name');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }

        // If the frontend failed to populate the *_name fields (e.g., JS didn't run),
        // attempt to resolve names from the EMSIFA APIs using the supplied IDs.
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
        } catch (\Throwable $e) {
            // If lookup fails, leave the names as-is; validation already passed for IDs.
        }

        $student = DB::transaction(function () use ($validated, $isDraft) {
            // Format address: Street, RT/RW, House No, Village, District, City, Province
            $parts = [$validated['street_address'] ?? ''];
            if (!empty($validated['rt'])) $parts[] = "RT " . $validated['rt'];
            if (!empty($validated['rw'])) $parts[] = "RW " . $validated['rw'];
            if (!empty($validated['house_number'])) $parts[] = "No. " . $validated['house_number'];
            if (!empty($validated['village_name'])) $parts[] = $validated['village_name'];
            if (!empty($validated['district_name'])) $parts[] = $validated['district_name'];
            if (!empty($validated['city_name'])) $parts[] = $validated['city_name'];
            if (!empty($validated['province_name'])) $parts[] = $validated['province_name'];
            if (!empty($validated['postal_code'])) $parts[] = "Kode Pos " . $validated['postal_code'];
            
            $fullAddress = implode(", ", array_filter($parts));

            $studentData = [
                'full_name' => ucwords(strtolower($validated['full_name'])),
                'nickname' => isset($validated['nickname']) ? ucwords(strtolower($validated['nickname'])) : null,
                'birth_place' => isset($validated['birth_place']) ? ucwords(strtolower($validated['birth_place'])) : null,
                'birth_date' => $validated['birth_date'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'religion' => $validated['religion'] ?? null,
                'address' => $fullAddress,
                'province_id' => $validated['province_id'] ?? null,
                'city_id' => $validated['city_id'] ?? null,
                'district_id' => $validated['district_id'] ?? null,
                'village_id' => $validated['village_id'] ?? null,
                'street_address' => $validated['street_address'] ?? null,
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
                'house_number' => $validated['house_number'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
            ];

            if (empty($validated['student_id'])) {
                $studentData['user_id'] = Auth::id();
                $studentData['status'] = 'draft';
                $student = Student::create($studentData);
            } else {
                $student = Student::findOrFail($validated['student_id']);
                if ($student->user_id !== Auth::id()) abort(403);
                $student->update($studentData);
            }

            StudentParent::updateOrCreate(
                ['student_id' => $student->id],
                [
                    'father_name' => isset($validated['father_name']) ? ucwords(strtolower($validated['father_name'])) : null,
                    'mother_name' => isset($validated['mother_name']) ? ucwords(strtolower($validated['mother_name'])) : null,
                    'father_occupation' => isset($validated['father_occupation']) ? ucwords(strtolower($validated['father_occupation'])) : null,
                    'father_phone' => $validated['father_phone'] ?? null,
                    'mother_occupation' => isset($validated['mother_occupation']) ? ucwords(strtolower($validated['mother_occupation'])) : null,
                    'phone' => $validated['phone'] ?? null,
                ]
            );

            return $student;
        });

        if ($isDraft) {
            return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan sebagai draft.');
        }

        // Check if student has payment history to restore status
        if ($student->payment && $student->payment->status === 'verified') {
            $student->update(['status' => 'paid']);
            // Redirect to dashboard since they are already paid
            return redirect()->route('dashboard')->with('success', 'Data berhasil diperbarui.');
        } elseif ($student->payment && $student->payment->status === 'pending') {
            $student->update(['status' => 'awaiting_payment']);
            return redirect()->route('payment.index', $student);
        } else {
             // Skip to Class Selection (Step 2 in new flow)
            // Mark as verified immediately since we are skipping document upload/verification for now
            $student->update(['status' => 'verified']);
            return redirect()->route('registration.class', $student);
        }
    }
    
    // Removed Step 2 & 3 methods


    public function step4(Student $student)
    {
        if ($student->user_id !== Auth::id()) abort(403);
        // Allow verified students
        // if ($student->status !== 'verified') return redirect()->route('dashboard');

        $classes = \App\Models\SchoolClass::whereRaw('filled < quota')->get();
        return view('registration.step4', compact('student', 'classes'));
    }

    public function storeStep4(Request $request, Student $student)
    {
        if ($student->user_id !== Auth::id()) abort(403);
        // if ($student->status !== 'verified') return redirect()->route('dashboard');

        $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        $class = \App\Models\SchoolClass::findOrFail($request->class_id);
        
        if ($class->filled >= $class->quota) {
            return back()->withErrors(['class_id' => 'Kelas penuh. Silakan pilih kelas lain.']);
        }

        DB::transaction(function () use ($student, $class) {
            \App\Models\ClassSelection::create([
                'student_id' => $student->id,
                'class_id' => $class->id,
                'status' => 'selected',
            ]);

            $class->increment('filled');
            $student->update(['status' => 'awaiting_payment']);
        });

        return redirect()->route('payment.index', $student);
    }
}
