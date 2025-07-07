<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kasir.app',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // User Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@kasir.app',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);
    }
}

