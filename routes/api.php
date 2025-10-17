<?php

use App\Http\Controllers\Api\User\RegisterController;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('register', [RegisterController::class, 'register'])
        ->name('user.register');
});