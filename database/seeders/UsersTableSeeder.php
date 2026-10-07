<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin'
        ]);

        // Doctor
        User::create([
            'name' => 'Dr. Rahul Sharma',
            'email' => 'doctor@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor'
        ]);

        // Patient
        User::create([
            'name' => 'John Doe',
            'email' => 'patient@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}