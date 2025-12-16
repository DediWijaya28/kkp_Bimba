<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Parent Account (Ready for Warranty Step)
        $user = User::updateOrCreate(
            ['email' => 'parent@bimba.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'parent',
                'email_verified_at' => now(),
            ]
        );

        $student = Student::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => 'Anak Budi',
                'nickname' => 'Budi Jr',
                'birth_place' => 'Jakarta',
                'birth_date' => '2018-01-01',
                'gender' => 'L',
                'religion' => 'Islam',
                'address' => 'Jl. Contoh No. 123, Jakarta Selatan',
                'status' => 'draft', // Set to draft so they land on Step 1/2
            ]
        );

        StudentParent::updateOrCreate(
            ['student_id' => $student->id],
            [
                'father_name' => 'Budi Santoso',
                'mother_name' => 'Siti Aminah',
                'father_occupation' => 'Karyawan Swasta',
                'mother_occupation' => 'Ibu Rumah Tangga',
                'phone' => '081234567890',
            ]
        );

        // 2. Verified Account (Ready for Class Selection)
        $userVerified = User::updateOrCreate(
            ['email' => 'verified@bimba.com'],
            [
                'name' => 'Andi Wijaya',
                'password' => Hash::make('password'),
                'role' => 'parent',
                'email_verified_at' => now(),
            ]
        );

        $studentVerified = Student::updateOrCreate(
            ['user_id' => $userVerified->id],
            [
                'full_name' => 'Anak Andi',
                'nickname' => 'Andi Jr',
                'birth_place' => 'Bandung',
                'birth_date' => '2018-05-05',
                'gender' => 'L',
                'religion' => 'Islam',
                'address' => 'Jl. Merdeka No. 45, Bandung',
                'status' => 'verified',
            ]
        );

        StudentParent::updateOrCreate(
            ['student_id' => $studentVerified->id],
            [
                'father_name' => 'Andi Wijaya',
                'mother_name' => 'Rina Sari',
                'father_occupation' => 'Wiraswasta',
                'mother_occupation' => 'Guru',
                'phone' => '089876543210',
            ]
        );
        
        // Create dummy warranty for verified student
        \App\Models\Warranty::create([
            'student_id' => $studentVerified->id,
            'signed_at' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Demo Seeder',
        ]);
        
        // Create dummy documents for verified student
        \App\Models\Document::create(['student_id' => $studentVerified->id, 'type' => 'akta', 'path' => 'demo/akta.jpg', 'status' => 'approved']);
        \App\Models\Document::create(['student_id' => $studentVerified->id, 'type' => 'kk', 'path' => 'demo/kk.jpg', 'status' => 'approved']);
        \App\Models\Document::create(['student_id' => $studentVerified->id, 'type' => 'foto', 'path' => 'demo/foto.jpg', 'status' => 'approved']);
    }
}
