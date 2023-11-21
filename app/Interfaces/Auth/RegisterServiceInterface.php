<?php

namespace App\Interfaces\Auth;

use Laravel\Passport\PersonalAccessTokenResult;

//use Laravel\Sanctum\NewAccessToken;

interface RegisterServiceInterface
{
    public function registerUser( string $name, string $email, string $password): PersonalAccessTokenResult;
}
