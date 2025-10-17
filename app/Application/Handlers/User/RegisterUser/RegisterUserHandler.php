<?php

namespace App\Application\Handlers\User\RegisterUser;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Application\Commands\User\RegisterUser\RegisterUserCommand;

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
        $user = User::create([
            'first_name' => $command->firstName,
            'last_name' => $command->lastName,
            'user_name' => $command->userName,
            'id_number' => $command->idNumber,
            'email' => $command->email,
            'password' => Hash::make($command->password),
        ]);

        $token = $user->createToken("API-Token-{$user->user_name}")->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
