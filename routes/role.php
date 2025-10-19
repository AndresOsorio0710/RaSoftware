<?php

use App\Http\Controllers\Api\Role\CreateRoleController;
use App\Http\Controllers\Api\Role\GetRoleController;
use App\Http\Controllers\Api\Role\ListRoleController;
use App\Http\Controllers\Api\Role\UpdateRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('role')->group(function () {
    Route::post('', [CreateRoleController::class, 'create'])->name('role.create');
    Route::get('', [ListRoleController::class, 'list'])->name('role.list');
    Route::get('/{id}', [GetRoleController::class, 'get'])->name('role.get');
    Route::put('/{id}', [UpdateRoleController::class, 'update'])->name('role.update');
});
