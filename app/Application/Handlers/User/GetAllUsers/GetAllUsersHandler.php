<?php

namespace App\Application\Handlers\User\GetAllUsers;

use App\Application\Queries\User\GetAllUsers\GetAllUsersQuery;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;

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
            // 1. Ejecutar la consulta de forma segura
            $users = User::orderBy('id_number', 'asc')->get();
            
            // 2. Retornamos el objeto paginado directamente
            return $users;

        } catch (QueryException $e) {
            // Manejar errores específicos de base de datos (conexión, sintaxis, etc.)
            // En CQRS/DDD, a menudo lanzamos una excepción de dominio (DomainException)
            // Aquí, lanzaremos una excepción simple para que el controlador la atrape.
            throw new Exception("Error de base de datos al recuperar usuarios.", 500); 
            
        } catch (Exception $e) {
            // Manejar cualquier otro error no esperado
            throw new Exception("Ocurrió un error inesperado: " . $e->getMessage(), 500);
        }
    }
}
