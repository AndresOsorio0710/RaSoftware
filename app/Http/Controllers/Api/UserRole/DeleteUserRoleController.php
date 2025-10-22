<?php

namespace App\Http\Controllers\Api\UserRole;

use App\Application\Handlers\UserRole\DeleteUserRole\DeleteUserRoleHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRole\UserRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DeleteUserRoleController extends Controller
{
    protected $handler;

    public function __construct(DeleteUserRoleHandler $deleteUserRoleHandler)
    {
        $this->handler = $deleteUserRoleHandler;
    }

    public function delete(UserRoleRequest $request): JsonResponse
    {
        Log::info('Inicio de solicitud de revocación de rol a usuario');

        $userId = $request->validated('user_id');
        $roleId = $request->validated('role_id');

        return $this->handler->handler($userId, $roleId);
    }
}
