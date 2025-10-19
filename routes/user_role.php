<?php

use App\Http\Controllers\Api\UserRole\CreateUserRoleController;
use App\Http\Controllers\Api\UserRole\DeleteUserRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('user/role')->group(function () {
    Route::post('', [CreateUserRoleController::class, 'create'])->name('user_role.create');
    Route::delete('', [DeleteUserRoleController::class, 'delete'])->name('user_role.delete');
});
