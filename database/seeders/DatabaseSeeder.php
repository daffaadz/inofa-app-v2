<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User (ID: 1) - MUST BE FIRST
        User::firstOrCreate(
            ['email' => 'admin@inofa.com'],
            [
                'name' => 'Admin InoFa',
                'email' => 'admin@inofa.com',
                'password' => Hash::make('inofasite'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Test User (ID: 2)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'role' => 'consumer',
                'email_verified_at' => now(),
            ]
        );
    }
}
