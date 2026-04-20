<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@prueba.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );
    }
}
