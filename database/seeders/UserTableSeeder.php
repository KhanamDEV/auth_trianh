<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'  => 'Kha Nam',
                'password' => Hash::make("12345678"),
                'email' => 'khanamdev@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
