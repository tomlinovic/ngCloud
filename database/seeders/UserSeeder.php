<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'is_super_user' => true,
        ]);

        User::create([
            'username' => 'testuser',
            'password' => Hash::make('user123'),
            'is_super_user' => false,
        ]);

        User::factory()
            ->count(5)
            ->superUser()
            ->create();

        User::factory()
            ->count(5)
            ->regularUser()
            ->create();
    }
}