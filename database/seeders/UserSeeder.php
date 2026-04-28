<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@fitarself.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'locale' => 'en',
        ]);

        // Regular user
        User::create([
            'name' => 'Karwan M.',
            'email' => 'user@fitarself.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'locale' => 'en',
            'city' => 'Duhok',
        ]);
    }
}