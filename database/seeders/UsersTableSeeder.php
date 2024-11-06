<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Nama Pengguna',
            'email' => 'email@example.com',
            'password' => bcrypt('password_baru'), // Ganti dengan password yang Anda inginkan
        ]);
    }
}