<?php

namespace App\Http\Controllers\Api\Auth;

use App\Application\Handlers\Auth\LoginHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $handler;

    public function __construct(LoginHandler $loginHandler)
    {
        $this->handler = $loginHandler;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $userName = $request->validated('user_name');

        Log::info('Inicio de solicitud de login.', ['user_name' => $userName]);

        $password = $request->validated('password');

        return $this->handler->handler($userName, $password);
    }
}
