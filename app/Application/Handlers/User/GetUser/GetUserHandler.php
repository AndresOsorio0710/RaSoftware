<?php

namespace App\Application\Handlers\User\GetUser;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class GetUserHandler
{
    /**
     * Create a new class instance. 
     */
    public function __construct()
    {
        //
    }

    public function handler(string $uuid): User
    {
        try {
            if (!\Illuminate\Support\Str::isUuid($uuid)) {
                throw new \InvalidArgumentException("El formato del identificador no es un UUID válido.", 409);
            }

            $user = User::findOrFail($uuid);

            Log::info("Usuario con UUID:$uuid, encontrado.", ['uuid' => $uuid]);
            return $user;
        } catch (ModelNotFoundException $e) {
            Log::info("Usuario con UUID:$uuid, no encontrado.", ['uuid' => $uuid]);
            throw new ModelNotFoundException("No se encontraron datos del usuario.", 404);
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar usuario.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);
            throw new Exception("Error de base de datos al recuperar usuario.", 500);
        } catch (Exception $e) {
            $exceptionType = get_class($e);
            Log::error('Ocurrió un error inesperado.', [
                'exception_type' => $exceptionType,
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);
            throw new Exception("Ocurrió un error inesperado: " . $e->getMessage(), 500);
        }
    }
}
