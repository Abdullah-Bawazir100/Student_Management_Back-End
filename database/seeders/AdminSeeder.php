<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\app_users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app_users::create([
            'user_email' => 'admin@gmail.com', // البريد الإلكتروني
            'user_password' => Hash::make('1234567'), // كلمة المرور مشفرة
            'user_role' => 'admin' // تحديد الدور كأدمن
        ]);
    }
}
