<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'r_password' => '12345678',
                'image' => 'admin.png',
                'role' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'hoang00090@gmail.com',
                'password' => Hash::make('12345678'),
                'r_password' => '12345678',
                'image' => 'user.png',
                'role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}