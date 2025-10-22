<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programTypes = ['PREGRADO', 'POSTGRADO'];
        $programsToSeed = [];

        // 1. Obtener ID y Nombre de todas las Facultades
        $faculties = Faculty::select('id', 'name')->get();

        if ($faculties->isEmpty()) {
            $this->command->error('No se encontraron Facultades. Ejecuta FacultySeeder primero.');
            return;
        }

        // 2. Obtener el ID del rol 'MANAGER'
        $managerRole = Role::where('name', 'MANAGER')->first();

        if (!$managerRole) {
            $this->command->error('El rol MANAGER no fue encontrado. Verifica RoleSeeder.');
            return;
        }

        // 3. Obtener los user_id de todos los usuarios con el rol 'MANAGER'
        $managerUserIds = DB::table('role_user')
            ->where('role_id', $managerRole->id)
            ->pluck('user_id')
            ->toArray();

        if (empty($managerUserIds)) {
            $this->command->error('No se encontraron usuarios con el rol MANAGER. Verifica UserSeeder y RoleUserSeeder.');
            return;
        }

        $now = Carbon::now();

        // 4. Generar 2 programas por cada facultad
        foreach ($faculties as $faculty) {
            $programCounter = 1; // Reinicia el contador para cada facultad

            foreach ($programTypes as $type) {
                // Generar un nombre compuesto: [NOMBRE FACULTAD] - [TIPO] PRUEBA #[1 o 2]
                $programName = strtoupper("{$faculty->name} - {$type} PRUEBA #{$programCounter}");

                $programsToSeed[] = [
                    'id' => Str::uuid()->toString(),
                    'faculty_id' => $faculty->id,
                    'manager_id' => Arr::random($managerUserIds), // Asignar Manager al azar
                    'name' => $programName,
                    // Asegurar referencia única
                    'reference' => strtoupper(substr($type, 0, 3)) . Str::random(5) . $programCounter,
                    'type_program' => $type,
                    'number_semesters' => ($type === 'PREGRADO' ? rand(6, 10) : rand(2, 4)),
                    'number_credits' => ($type === 'PREGRADO' ? rand(100, 180) : rand(40, 80)),
                    'description' => "Descripción de prueba para el programa {$programName}.",
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $programCounter++;
            }
        }

        // 5. Inserción masiva de los programas
        DB::table('programs')->upsert(
            $programsToSeed,
            ['reference'], // Clave de unicidad
            ['faculty_id', 'manager_id', 'name', 'type_program', 'number_semesters', 'number_credits', 'description', 'updated_at']
        );

        $this->command->info(count($programsToSeed) . ' programas (PREGRADO/POSTGRADO) creados exitosamente y asignados a Managers.');
    }
}
