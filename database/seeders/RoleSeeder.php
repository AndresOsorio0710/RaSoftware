<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'SUPER ADMIN' => 'Super administrador del sistema con acceso total.',
            'ADMIN' => 'Administrador del negocio con acceso total.',
            'DIRECTOR' => 'Director del plantel.',
            'MANAGER' => 'Jefe o director de programa.',
            'LIDER' => 'Líder de momento.',
            'TEACHER' => 'Profesor lider de grupo encargado de evaluar RAA.',
            'EVALUATOR' => 'Evaluador encargado de evaluar RAP.',
            'STUDENT' => 'Estudiante (Rol por defecto).',
        ];

        DB::transaction(function () use ($roles) {
            foreach ($roles as $name => $description) {
                Role::firstOrCreate(
                    ['name' => $name],
                    ['description' => $description]
                );
            }
            $this->command->info('Roles base creados exitosamente.');
        });
    }
}
