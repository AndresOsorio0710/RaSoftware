<?php

namespace App\Application\Handlers\User\RegisterUser;


use App\Application\Commands\User\RegisterUser\RegisterUserCommand;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterUserHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(RegisterUserCommand $command): array
    {
        try{
            $userName = explode('@', $command->email)[0];

            $data = [
                'first_name' => $command->firstName,
                'last_name' => $command->lastName,
                'user_name' => $userName,
                'id_number' => $command->idNumber,
                'email' => $command->email,
                'password' => Hash::make($command->password),
            ];

            $user = User::create($data);

            $token = $user->createToken("API-Token-{$user->user_name}")->plainTextToken;

            Log::info('Handler ejecutado con éxito.');
            return [
                'user' => $user,
                'token' => $token,
            ];
        }catch (QueryException $e) {
            Log::error('Error de base de datos al intentar registrar un usuarios.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);
            throw new Exception("Error de base de datos al intentar registrar un usuarios.", 500); 
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
