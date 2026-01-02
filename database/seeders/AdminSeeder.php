<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan firstOrCreate agar TIDAK me-reset password jika admin sudah ada.
        // Gunakan Env Variable agar password awal bisa di-set dari luar (.env)
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@bimba.com')],
            [
                'name' => 'Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
