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
            ['email' => 'carlosmrc1967@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
            ]
        );
    }
}
