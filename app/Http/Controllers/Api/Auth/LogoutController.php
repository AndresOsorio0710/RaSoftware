<?php

namespace App\Http\Controllers\Api\Auth;

use App\Core\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success("Sesión cerrada exitosamente.");
    }
}
