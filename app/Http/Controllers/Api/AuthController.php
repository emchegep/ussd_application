<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validated($request->all());

        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->error('Invalid Credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->success(
            message:'Authenticated',
            data:[
              'token' => $user->createToken('API token for ' . $user->email)->plainTextToken,
            ],
            statusCode: 200
        );
    }

    public function register()
    {
        return $this->ok("Registered");
    }
}
