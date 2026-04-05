<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    // 1. Jalankan Seeder Soal & Kategori
        $this->call([
        QuizSeeder::class,
        ]);

    // 2. Buat Akun Guru
        \App\Models\User::factory()->create([
            'name' => 'Pak Guru Reza',
            'email' => 'guru@example.com',
            'password' => bcrypt('password123'),
            'role' => 'guru',
        ]);

    // 3. Buat Akun Siswa (Opsional untuk testing)
        \App\Models\User::factory()->create([
            'name' => 'Test Siswa',
            'email' => 'siswa@test.com',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
        ]);
    }
}
