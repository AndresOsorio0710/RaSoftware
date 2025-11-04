<?php

namespace App\Http\Controllers\Api\Period;

use App\Application\Handlers\Period\GetPeriod\GetPeriodHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetPeriodController extends Controller
{
    protected $handler;

    public function __construct(GetPeriodHandler $getPeriodHandler)
    {
        $this->handler = $getPeriodHandler;
    }

    public function get(string $id): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de información de periodo por id.');
        return $this->handler->handler($id);
    }
}
