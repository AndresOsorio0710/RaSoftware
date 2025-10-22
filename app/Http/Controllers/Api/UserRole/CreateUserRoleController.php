<?php

namespace App\Http\Controllers\Api\UserRole;

use App\Application\Handlers\UserRole\CreateUserRole\CreateUserRoleHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRole\UserRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateUserRoleController extends Controller
{
    protected $handler;

    public function __construct(CreateUserRoleHandler $createUserRoleHandler)
    {
        $this->handler = $createUserRoleHandler;
    }

    public function create(UserRoleRequest $request): JsonResponse
    {
        Log::info('Inicio de solicitud de asignación de rol a usuario.');

        $userId = $request->validated('user_id');
        $roleId = $request->validated('role_id');

        return $this->handler->handler($userId, $roleId);
    }
}
