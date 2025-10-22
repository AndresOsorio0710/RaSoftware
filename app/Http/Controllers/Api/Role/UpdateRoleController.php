<?php

namespace App\Http\Controllers\Api\Role;

use App\Application\Handlers\Role\UpdateRole\UpdateRoleHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UpdateRoleController extends Controller
{
    protected $handler;

    public function __construct(UpdateRoleHandler $updateRoleHandler)
    {
        $this->handler = $updateRoleHandler;
    }

    public function update(string $id, UpdateRoleRequest $request): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de actualización de rol.', ['id' => $id]);

        $data = $request->validated();

        return $this->handler->handler($id, $data);
    }
}
