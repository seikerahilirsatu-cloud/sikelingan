<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // upsert admin user to be idempotent
        $adminEmail = 'admin@example.com';
        $exists = DB::table('users')->where('email', $adminEmail)->first();
        $data = [
            'name' => 'Admin User',
            'email' => $adminEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'updated_at' => now(),
        ];

        if ($exists) {
            DB::table('users')->where('email', $adminEmail)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('users')->insert($data);
        }
    }
}
