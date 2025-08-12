<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <-- ADICIONE ESTA LINHA
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@biblioteca.com'],
            ['name' => 'Admin', 'password' => Hash::make('admin123')]
        );
        // Atribui o papel de admin ao usuário
        $user->assignRole('admin');
    }
}