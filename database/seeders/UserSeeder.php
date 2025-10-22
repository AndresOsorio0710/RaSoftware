<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersToSeed = [];

        $usersToSeed[] = [
            'id' => '10000000-0000-0000-0000-000000000001',
            'id_number' => '100000000',
            'user_name' => 'sadmin',
            'first_name' => 'ROOT',
            'last_name' => 'SMIT',
            'email' => 'sadmin@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('Pass1234!'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $this->command->info("1 Super Admin cargado.");

        $adminCount = 3;
        $baseIdNumberManager = 200000000;

        for ($i = 0; $i < $adminCount; $i++) {
            $idNumber = (string)($baseIdNumberManager + $i);
            $userName = 'admin' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $usersToSeed[] = [
                'id' => Str::uuid()->toString(),
                'id_number' => $idNumber,
                'user_name' => $userName,
                'first_name' => 'SOY',
                'last_name' => "ADMIN " . ($i + 1),
                'email' => $userName . '@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Pass1234!'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->command->info("3 Admin cargados.");

        $managerCount = 10;
        $baseIdNumberLider = 300000000;

        for ($i = 0; $i < $managerCount; $i++) {
            $idNumber = (string)($baseIdNumberLider + $i);
            $userName = 'manager' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $usersToSeed[] = [
                'id' => Str::uuid()->toString(),
                'id_number' => $idNumber,
                'user_name' => $userName,
                'first_name' => 'SOY',
                'last_name' => "MANAGER " . ($i + 1),
                'email' => $userName . '@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Pass1234!'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->command->info("10 Manager cargados.");

        $liderCount = 10;
        $baseIdNumberLider = 400000000;

        for ($i = 0; $i < $liderCount; $i++) {
            $idNumber = (string)($baseIdNumberLider + $i);
            $userName = 'lider' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $usersToSeed[] = [
                'id' => Str::uuid()->toString(),
                'id_number' => $idNumber,
                'user_name' => $userName,
                'first_name' => 'SOY',
                'last_name' => "LIDER " . ($i + 1),
                'email' => $userName . '@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Pass1234!'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->command->info("10 Lider cargados.");

        $teacherCount = 60;
        $baseIdNumberLider = 500000000;

        for ($i = 0; $i < $teacherCount; $i++) {
            $idNumber = (string)($baseIdNumberLider + $i);
            $userName = 'teacher' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $usersToSeed[] = [
                'id' => Str::uuid()->toString(),
                'id_number' => $idNumber,
                'user_name' => $userName,
                'first_name' => 'SOY',
                'last_name' => "TEACHER " . ($i + 1),
                'email' => $userName . '@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Pass1234!'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->command->info("60 Teacher cargados.");

        $evaluatorCount = 60;
        $baseIdNumberLider = 600000000;

        for ($i = 0; $i < $evaluatorCount; $i++) {
            $idNumber = (string)($baseIdNumberLider + $i);
            $userName = 'evaluator' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $usersToSeed[] = [
                'id' => Str::uuid()->toString(),
                'id_number' => $idNumber,
                'user_name' => $userName,
                'first_name' => 'SOY',
                'last_name' => "EVALUATOR " . ($i + 1),
                'email' => $userName . '@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Pass1234!'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->command->info("60 Evaluator cargados.");

        $studentCount = 200;
        $baseIdNumberLider = 700000000;

        for ($i = 0; $i < $studentCount; $i++) {
            $idNumber = (string)($baseIdNumberLider + $i);
            $userName = 'student' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $usersToSeed[] = [
                'id' => Str::uuid()->toString(),
                'id_number' => $idNumber,
                'user_name' => $userName,
                'first_name' => 'SOY',
                'last_name' => "STUDENT " . ($i + 1),
                'email' => $userName . '@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Pass1234!'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->command->info("200 Student cargados.");

        $totalUsers = 1 +  $adminCount + $managerCount + $liderCount + $teacherCount + $evaluatorCount + $studentCount;

        $this->command->comment("Registrando $totalUsers usuarios...");

        DB::table('users')->upsert(
            $usersToSeed,
            ['id_number'],
            ['user_name', 'email', 'first_name', 'last_name', 'password', 'updated_at']
        );
        $this->command->info("$totalUsers usuarios (SADMIN, ADMIN, MANAGER, LIDER, TEACHER, EVALUATOR y STUDENT) creados/actualizados exitosamente.");
    }
}
