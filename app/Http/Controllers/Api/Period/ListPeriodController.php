<?php

namespace App\Http\Controllers\Api\Period;

use App\Application\Handlers\Period\ListPeriod\ListPeriodByPerogramIdHandler;
use App\Application\Handlers\Period\ListPeriod\ListPeriodHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListPeriodController extends Controller
{
    protected $listPeriodHandler;
    protected $listPeriodByProgramIdHandler;

    public function __construct(
        ListPeriodHandler $listPeriodHandler,
        ListPeriodByPerogramIdHandler $listPeriodByPerogramIdHandler,
    ) {
        $this->listPeriodHandler = $listPeriodHandler;
        $this->listPeriodByProgramIdHandler = $listPeriodByPerogramIdHandler;
    }

    public function list(): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de períodos.');
        return $this->listPeriodHandler->handler();
    }

    public function listByProgramId(string $programId): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de períodos por program_id.');
        return $this->listPeriodByProgramIdHandler->handler($programId);
    }
}
