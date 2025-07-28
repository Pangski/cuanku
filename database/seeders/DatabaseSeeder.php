<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use App\Enums\RoleType; // Aktifkan jika kamu pakai Enum

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat user admin default
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@cuanku.com',
            'password' => Hash::make('password'), // Lebih aman dari bcrypt()
            'role' => 'admin', // Jika pakai Enum: RoleType::ADMIN->value,
            'is_active' => true,
            'is_agentic' => false,
        ]);
    }
}
