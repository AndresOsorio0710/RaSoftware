<?php

namespace App\Http\Controllers\Api\Role;

use App\Application\Handlers\Role\ListRole\ListRoleHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListRoleController extends Controller
{
    protected $handler;

    public function __construct(ListRoleHandler $listRoleHandler)
    {
        $this->handler = $listRoleHandler;
    }

    public function list(): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de roles.');
        return $this->handler->handler();
    }
}
