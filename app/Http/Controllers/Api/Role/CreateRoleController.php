<?php

namespace App\Http\Controllers\Api\Role;

use App\Application\Handlers\Role\CreateRole\CreateRoleHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateRoleController extends Controller
{
    protected $handler;
    public function __construct(CreateRoleHandler $createRoleHandler)
    {
        $this->handler = $createRoleHandler;
    }

    public function create(CreateRoleRequest $request): JsonResponse
    {
        Log::info('Inicio de solicitud de creación de rol.');

        $data = $request->validated();

        return $this->handler->handler($data);
    }
}
