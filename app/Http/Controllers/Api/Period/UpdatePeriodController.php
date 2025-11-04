<?php

namespace App\Http\Controllers\Api\Period;

use App\Application\Handlers\Period\UpdatePeriod\UpdatePeriodHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Period\UpdatePeriodRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UpdatePeriodController extends Controller
{
    protected $handler;

    public function __construct(UpdatePeriodHandler $updatePeriodHandler)
    {
        $this->handler = $updatePeriodHandler;
    }

    public function update(string $id, UpdatePeriodRequest $request): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de actualización de periodo.', ['id' => $id]);

        $data = $request->validated();

        return $this->handler->handler($id, $data);
    }
}
