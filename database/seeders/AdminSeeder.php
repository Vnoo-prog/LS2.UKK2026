<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'min',
            'password' => '123', 
            'email' => 'admin@gmail.com',
            'nama_lengkap' => 'sulfin',
            'alamat' => 'Ruang Kepala Perpustakaan',
            'role' => 'admin'
        ]);
    }
}
