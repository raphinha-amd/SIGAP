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
        // User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'nik' => '3272031807070001',
            'no_telp' => '081234567890',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status_akun' => true,
        ]);
        User::create([
            'name' => 'petugas',
            'email' => 'petugas@example.com',
            'nik' => '3272031807070002',
            'no_telp' => '081234567891',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'status_akun' => true,
        ]);
        User::create([
            'name' => 'masyarakat 1',
            'email' => 'masyarakat1@example.com',
            'nik' => '3272031807070003',
            'no_telp' => '081234567892',
            'password' => bcrypt('password'),
            'role' => 'masyarakat',
            'status_akun' => true,
        ]);
        User::create([
            'name' => 'masyarakat 2',
            'email' => 'masyarakat2@example.com',
            'nik' => '3272031807070004',
            'no_telp' => '081234567893',
            'password' => bcrypt('password'),
            'role' => 'masyarakat',
            'status_akun' => true,
        ]);
    }
}
