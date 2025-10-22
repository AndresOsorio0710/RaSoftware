<?php

namespace App\Http\Controllers\Api\Faculty;

use App\Application\Handlers\Faculty\CreateFaculty\CreateFacultyHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faculty\CreateFacultyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateFacultyController extends Controller
{
    protected $handler;

    public function __construct(CreateFacultyHandler $createFacultyHandler)
    {
        $this->handler = $createFacultyHandler;
    }

    public function create(CreateFacultyRequest $request): JsonResponse
    {
        Log::info('Inicio de solicitud de creación de facultad.');

        $data = $request->validated();

        return $this->handler->handler($data);
    }
}
