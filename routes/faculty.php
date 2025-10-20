<?php

use App\Http\Controllers\Api\Faculty\CreateFacultyController;
use App\Http\Controllers\Api\Faculty\GetFacultyController;
use App\Http\Controllers\Api\Faculty\ListFacultyController;
use App\Http\Controllers\Api\Faculty\UpdateFacultyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('faculty')->group(function () {
    Route::middleware('role.admin')->group(function () {
        Route::post('', [CreateFacultyController::class, 'create'])->name('faculty.create');
        Route::get('', [ListFacultyController::class, 'list'])->name('faculty.list');
        Route::get('/{id}', [GetFacultyController::class, 'get'])->name('faculty.get');
        Route::put('/{id}', [UpdateFacultyController::class, 'update'])->name('faculty.update');
    });
});
