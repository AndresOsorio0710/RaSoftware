<?php

namespace App\Http\Controllers\Api\Faculty;

use App\Application\Handlers\Faculty\GetFaculty\GetFacultyHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetFacultyController extends Controller
{
    protected $handler;

    public function __construct(GetFacultyHandler $getFacultyHandler)
    {
        $this->handler = $getFacultyHandler;
    }

    public function get(string $id): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de información de facultad por id.');
        return $this->handler->handler($id);
    }
}
