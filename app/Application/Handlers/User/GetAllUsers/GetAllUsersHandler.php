<?php

namespace App\Application\Handlers\User\GetAllUsers;

use App\Application\Queries\User\GetAllUsers\GetAllUsersQuery;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class GetAllUsersHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(GetAllUsersQuery $query)
    {
        try {
            $users = User::orderBy('id_number', 'asc')->get();
            
            Log::info('Handler ejecutado con éxito.');
            return $users;

        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar usuarios.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);
            throw new Exception("Error de base de datos al recuperar usuarios.", 500); 
            
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);
            throw new Exception("Ocurrió un error inesperado: " . $e->getMessage(), 500);
        }
    }
}
