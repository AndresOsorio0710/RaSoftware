<?php

namespace App\Http\Controllers\Api\UserRole;

use App\Application\Handlers\UserRole\ListUserRole\ListUserRoleHandler;
use App\Core\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ListUserRoleController extends Controller
{
    protected $handler;

    public function __construct(ListUserRoleHandler $listUserRoleHandler)
    {
        $this->handler = $listUserRoleHandler;
    }

    public function getUsersByRole(string $roleName)
    {
        Log::info('Inicio de procesamiento de consulta de uaurios por rol.');

        if (empty($roleName)) {
            Log::info('El parámetro "roleName" es obligatorio en la consulta.');

            return ApiResponse::errorConflict('El parámetro "roleName" es obligatorio en la consulta.');
        }

        return $this->handler->handler(strtoupper($roleName));
    }
}
