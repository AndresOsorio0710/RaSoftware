<?php

namespace App\Http\Controllers\Api\Program;

use App\Application\Handlers\Program\CreateProgram\CreateProgramHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Program\CreateProgramRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateProgramController extends Controller
{
    protected $handler;

    public function __construct(CreateProgramHandler $createProgramHandler)
    {
        $this->handler = $createProgramHandler;
    }

    public function create(CreateProgramRequest $request): JsonResponse
    {
        Log::info('Inicio de solicitud de creación de programa.');

        $data = $request->validated();

        return $this->handler->handler($data);
    }
}
