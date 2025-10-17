<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RequestTraceability
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $correlationId = (string) Str::uuid();

        // 2. Inyecta el ID en el contexto de Monolog (el array 'context' del log)
        // Todos los logs generados durante esta petición incluirán este ID.
        Log::shareContext(['correlation_id' => $correlationId]);

        $response = $next($request);

        // 3. Añade el ID al encabezado de la respuesta HTTP
        $response->headers->set('X-Correlation-ID', $correlationId);

        return $response;
    }
}
