<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => '10000000-0000-0000-0000-000000000001',
            'id_number' => '100000000',
            'user_name' => 'sadmin',
            'first_name' => 'ROOT',
            'last_name' => 'SMIT',
            'email' => 'sadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Pass1234!'),
            'remember_token' => Str::random(10),
        ]);
    }
}
