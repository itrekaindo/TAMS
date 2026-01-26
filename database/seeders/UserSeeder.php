<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin
        User::create([
            'name' => 'Administrator',
            'email' => 'Ppcreka1@gmail.com',
            'password' => Hash::make('Reka123456'),
            'role' => 'admin',
        ]);

        // Buat user staff
        User::create([
            'name' => 'Tools Keeper',
            'email' => 'rekappc03@gmail.com',
            'password' => Hash::make('@Rekappc1234'),
            'role' => 'toolskeeper',
        ]);
    }
}
