<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            'FACULTAD DE PRUEBA' => 'Esta es una facultad de prueba',
        ];

        DB::transaction(function () use ($faculties) {
            foreach ($faculties as $name => $description) {
                Faculty::firstOrCreate(
                    ['name' => $name],
                    ['description' => $description]
                );
            }
            $this->command->info('Facultades base creadas exitosamente.');
        });
    }
}
