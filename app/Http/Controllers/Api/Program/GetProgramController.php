<?php

namespace App\Http\Controllers\Api\Program;

use App\Application\Handlers\Program\GetProgram\GetProgramHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetProgramController extends Controller
{
    protected $handler;

    public function __construct(GetProgramHandler $getProgramHandler)
    {
        $this->handler = $getProgramHandler;
    }

    public function get(string $id): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de información de programa por id.');
        return $this->handler->handler($id);
    }
}
