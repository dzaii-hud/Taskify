<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@taskify.test',   // 👈 email admin
            ],
            [
                'name' => 'Super Admin Taskify',
                'password' => Hash::make('password123'), // 👈 password admin
                'role' => 'admin',
            ]
        );
    }
}
