<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTeachernRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();

        if (!($user->hasRole('TEACHER') || $user->hasRole('SUPER ADMIN'))) {
            return response()->json([
                'message' => 'Acceso denegado.'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
