<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // senha
            'role' => 'admin',
        ]);

        // Bibliotecário
        User::create([
            'name' => 'Bibliotecário',
            'email' => 'bibliotecario@example.com',
            'password' => Hash::make('biblio123'), // senha
            'role' => 'bibliotecario',
        ]);
    }
}
