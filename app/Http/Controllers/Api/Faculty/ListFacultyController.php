<?php

namespace App\Http\Controllers\Api\Faculty;

use App\Application\Handlers\Faculty\ListFaculty\ListFacultyHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListFacultyController extends Controller
{
    protected $handler;

    public function __construct(ListFacultyHandler $listFacultyHandler)
    {
        $this->handler = $listFacultyHandler;
    }

    public function list(): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de facultades.');
        return $this->handler->handler();
    }
}
