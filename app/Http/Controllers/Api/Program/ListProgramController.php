<?php

namespace App\Http\Controllers\Api\Program;

use App\Application\Handlers\Program\ListProgram\ListProgramByFacultyIdHandler;
use App\Application\Handlers\Program\ListProgram\ListProgramByManagerIdHandler;
use App\Application\Handlers\Program\ListProgram\ListProgramHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListProgramController extends Controller
{
    protected $listProgramHandler;
    protected $listProgramByFacultyIdHandler;
    protected $listProgramByManagerIdHandler;

    public function __construct(
        ListProgramHandler $listProgramHandler,
        ListProgramByFacultyIdHandler $listProgramByFacultyIdHandler,
        ListProgramByManagerIdHandler $listProgramByManagerIdHandler
    ) {
        $this->listProgramHandler = $listProgramHandler;
        $this->listProgramByFacultyIdHandler = $listProgramByFacultyIdHandler;
        $this->listProgramByManagerIdHandler = $listProgramByManagerIdHandler;
    }

    public function list(): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de programas.');
        return $this->listProgramHandler->handler();
    }

    public function listByFacultyId(string $facultyId): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de programas por faculty_id.');
        return $this->listProgramByFacultyIdHandler->handler($facultyId);
    }

    public function listByManagerId(string $managerId): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de programas por manager_id.');
        return $this->listProgramByManagerIdHandler->handler($managerId);
    }
}
