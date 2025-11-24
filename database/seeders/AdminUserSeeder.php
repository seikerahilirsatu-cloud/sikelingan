<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email = env('ADMIN_EMAIL', 'admin@sikelingan.local');
        $password = env('ADMIN_PASSWORD', 'Admin123!');
        $lingkungan = env('ADMIN_LINGKUNGAN');

        $exists = DB::table('users')->where('email', $email)->first();
        $data = [
            'name' => 'Administrator',
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'role' => 'admin',
            'lingkungan' => $lingkungan,
            'updated_at' => now(),
        ];

        if ($exists) {
            DB::table('users')->where('email', $email)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('users')->insert($data);
        }
    }
}
