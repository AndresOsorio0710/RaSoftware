<?php

use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserListController;
use App\Http\Controllers\Api\User\UserRegisterController;
use App\Http\Controllers\Api\User\UserUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('', [UserRegisterController::class, 'register'])->name('user.register');
    Route::get('', [UserListController::class, 'index'])->name('user.list');
    Route::get('/{id}', [UserController::class, 'findById'])->name('user.get');
    Route::put('/{id}', [UserUpdateController::class, 'update'])->name('user.update');
});
