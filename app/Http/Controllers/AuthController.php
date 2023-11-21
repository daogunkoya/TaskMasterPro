<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterUserRequest;
use App\Interfaces\Auth\LoginServiceInterface;
use App\Interfaces\Auth\RegisterServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected LoginServiceInterface $loginService;
    protected RegisterServiceInterface $registerService;


    public function __construct(LoginServiceInterface $loginService, RegisterServiceInterface $registerService)
    {
        $this->loginService = $loginService;
        $this->registerService = $registerService;
    }

public function index(){
        return Auth::id();
}

    public function register(RegisterUserRequest $request): JsonResponse
    {

        //$credentials = $request->only('email', 'password');
        $input = $request->all();

        try {
            $result = $this->registerService->registerUser(
                $input['name'],
                $input['email'],
                $input['password']
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return response()->json($result);
    }



    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            $result = $this->loginService->loginUser($credentials);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return response()->json($result ?? "");
    }

    public function test(Request $request)
    {
        return request()->user()->toArray();
    }
}
