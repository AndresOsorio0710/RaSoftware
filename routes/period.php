<?php

use App\Http\Controllers\Api\Period\CreatePeriodController;
use App\Http\Controllers\Api\Period\GetPeriodController;
use App\Http\Controllers\Api\Period\ListPeriodController;
use App\Http\Controllers\Api\Period\UpdatePeriodController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('period')->group(function () {
    Route::middleware('role.manager')->group(function () {
        Route::post('', [CreatePeriodController::class, 'create'])->name('period.create');
        Route::get('', [ListPeriodController::class, 'list'])->name('period.list');
        Route::get('/program/{programId}', [ListPeriodController::class, 'listByProgramId'])->name('period.listByProgramId');
        Route::get('/{id}', [GetPeriodController::class, 'get'])->name('period.get');
        Route::put('/{id}', [UpdatePeriodController::class, 'update'])->name('period.update');
    });
});
