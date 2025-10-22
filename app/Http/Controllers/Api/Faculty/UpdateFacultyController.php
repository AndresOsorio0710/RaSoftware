<?php

namespace App\Http\Controllers\Api\Faculty;

use App\Application\Handlers\Faculty\UpdateFaculty\UpdateFacultyHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faculty\UpdateFacultyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UpdateFacultyController extends Controller
{
    protected $handler;

    public function __construct(UpdateFacultyHandler $updateFacultyHandler)
    {
        $this->handler = $updateFacultyHandler;
    }

    public function update(string $id, UpdateFacultyRequest $request): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de actualización de facultad.', ['id' => $id]);

        $data = $request->validated();

        return $this->handler->handler($id, $data);
    }
}
