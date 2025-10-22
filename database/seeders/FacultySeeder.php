<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '10000000-0000-0000-0000-000000000001',
                'name' => 'FACULTAD DE PRUEBA 1',
                'description' => 'Facultad de prueba con ID fijo 1.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '10000000-0000-0000-0000-000000000002',
                'name' => 'FACULTAD DE PRUEBA 2',
                'description' => 'Facultad de prueba con ID fijo 2.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '10000000-0000-0000-0000-000000000003',
                'name' => 'FACULTAD DE PRUEBA 3',
                'description' => 'Facultad de prueba con ID fijo 3.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('faculties')->upsert(
            $data,
            ['name'],
            ['description', 'updated_at']
        );

        $this->command->info('Facultades base y de prueba creadas/actualizadas exitosamente.');
    }
}
