<?php

use App\Http\Controllers\Api\Program\CreateProgramController;
use App\Http\Controllers\Api\Program\GetProgramController;
use App\Http\Controllers\Api\Program\ListProgramController;
use App\Http\Controllers\Api\Program\UpdateProgramController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('program')->group(function () {
    Route::middleware('role.admin')->group(function () {
        Route::post('', [CreateProgramController::class, 'create'])->name('program.create');
        Route::get('', [ListProgramController::class, 'list'])->name('program.list');
        Route::get('/faculty/{facultyId}', [ListProgramController::class, 'listByFacultyId'])->name('program.listByFacultyId');
        Route::get('/manager/{managerId}', [ListProgramController::class, 'listByManagerId'])->name('program.listByManagerId');
        Route::get('/{id}', [GetProgramController::class, 'get'])->name('program.get');
        Route::put('/{id}', [UpdateProgramController::class, 'update'])->name('program.update');
    });
});
