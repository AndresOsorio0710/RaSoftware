<?php

use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserListController;
use App\Http\Controllers\Api\User\UserRegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('register', [UserRegisterController::class, 'register'])
        ->name('user.register');
    Route::get('', [UserListController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'findById']);
});