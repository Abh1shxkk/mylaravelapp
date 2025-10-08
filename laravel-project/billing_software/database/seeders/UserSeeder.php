<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12341234'),
                'role' => 'admin',
                'email_verified' => 1,
            ],
            [
                'name' => 'manager',
                'username' => 'manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('12341234'),
                'role' => 'manager',
                'email_verified' => 1,
            ],
            [
                'name' => 'user',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12341234'),
                'role' => 'user',
                'email_verified' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
