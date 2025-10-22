<?php

namespace App\Application\Commands\User\RegisterUser;

class RegisterUserCommand
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $idNumber
     * @param string $email
     * @param string $password Sin hashear, pues el Handler lo hará
     */
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $idNumber,
        public readonly string $email,
        public readonly string $password,
    ){}
}
