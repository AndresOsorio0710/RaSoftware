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
        $superAdminUserId = '10000000-0000-0000-0000-000000000001';
        $superAdminRole = Role::where('name', 'SUPER ADMIN')->first();
        if ($superAdminRole) {
            DB::table('role_user')->insert([
                'user_id' => $superAdminUserId,
                'role_id' => $superAdminRole->id,
            ]);
        }
    }
}
