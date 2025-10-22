<?php

namespace App\Http\Controllers\Api\Program;

use App\Application\Handlers\Program\UpdateProgram\UpdateProgramHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Program\UpdateProgramRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UpdateProgramController extends Controller
{
    protected $handler;

    public function __construct(UpdateProgramHandler $updateProgramHandler)
    {
        $this->handler = $updateProgramHandler;
    }

    public function update(string $id, UpdateProgramRequest $request): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de actualización de programa.', ['id' => $id]);

        $data = $request->validated();

        return $this->handler->handler($id, $data);
    }
}
