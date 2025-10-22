<?php

use App\Http\Controllers\Api\UserRole\CreateUserRoleController;
use App\Http\Controllers\Api\UserRole\DeleteUserRoleController;
use App\Http\Controllers\Api\UserRole\ListUserRoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('user/role')->group(function () {
    Route::middleware('role.admin')->group(function () {
        Route::post('', [CreateUserRoleController::class, 'create'])->name('user_role.create');
        Route::delete('', [DeleteUserRoleController::class, 'delete'])->name('user_role.delete');
        Route::get('/{roleName}', [ListUserRoleController::class, 'getUsersByRole'])->name('user_role.getUsersByRole');
    });
});
