<?php

namespace App\Http\Controllers\Api\Period;

use App\Application\Handlers\Period\CreatePeriod\CreatePeriodHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Period\CreatePeriodRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreatePeriodController extends Controller
{
    protected $handler;

    public function __construct(CreatePeriodHandler $createPeriodHandler)
    {
        $this->handler = $createPeriodHandler;
    }

    public function create(CreatePeriodRequest $request): JsonResponse
    {
        Log::info('Inicio de solicitud de creación de periodo.');

        $data = $request->validated();

        return $this->handler->handler($data);
    }
}
