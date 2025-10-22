<?php

namespace App\Http\Controllers\Api\Role;

use App\Application\Handlers\Role\GetRole\GetRoleHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetRoleController extends Controller
{
    protected $handler;

    public function __construct(GetRoleHandler $getRoleHandler)
    {
        $this->handler = $getRoleHandler;
    }

    public function get(string $id): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de información de rol por id.');
        return $this->handler->handler($id);
    }
}
