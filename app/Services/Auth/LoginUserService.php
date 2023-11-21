<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\MMUser;
use App\Interfaces\Auth\LoginServiceInterface;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Illuminate\Validation\ValidationException;

class LoginUserService implements LoginServiceInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<int,  mixed>
     * @param array<string,mixed> $credentials The credentials used to log in the user.
     */


    public function loginUser(array $credentials): array
    {

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        if (!$user instanceof User) {
            return [];
        }

        $token = $user->createToken('auth_token');
       // $res = ['token'=>$token, 'user' => $user];
        $res = $this->authResponse($token, $user);
        return $res;
    }



    public function authResponse($token, $user): array
    {

        $now = \Carbon\Carbon::now();
        return
            ['user_id' => $user['id'],
            'user_name' => $user['name'],
            'access_token' => $token->accessToken,
            'token_type' => 'bearer',
            'expires_in' => $now
                ];
    }


}
