<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all()
            ->pluck('id', 'name');

        $roleMapping = [
            '1' => $roles['SUPER ADMIN'],
            '2' => $roles['ADMIN'],
            '3' => $roles['MANAGER'],
            '4' => $roles['LIDER'],
            '5' => $roles['TEACHER'],
            '6' => $roles['EVALUATOR'],
            '7' => $roles['STUDENT'],
        ];

        $users = DB::table('users')->select('id', 'id_number')->get();

        if ($users->isEmpty()) {
            $this->command->error('ADVERTENCIA: No se devolvió ningún usuario. Verifica que UserSeeder se haya ejecutado primero.');
            return;
        }

        $this->command->comment("DEBUG: Se encontraron {$users->count()} usuarios para procesar y asignar roles.");

        $userRoleData = [];
        $rolesAssignedCount = 0;

        foreach ($users as $user) {
            $idNumberPrefix = substr((string) $user->id_number, 0, 1);
            $roleId = $roleMapping[$idNumberPrefix] ?? null;

            if ($roleId) {
                $userRoleData[] = [
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                ];
                $rolesAssignedCount++;
            }
        }

        if (!empty($userRoleData)) {
            DB::table('role_user')->upsert(
                $userRoleData,
                ['user_id', 'role_id']
            );
            $this->command->info("Se asignaron $rolesAssignedCount roles a los usuarios basándose en el prefijo del número de identificación.");
        } else {
            $this->command->warn('No se encontró data para asignar roles. Verifica la coincidencia de prefijos de ID con el mapeo.');
        }
    }
}
