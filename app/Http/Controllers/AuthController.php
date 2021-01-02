<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'status' => 'failed']);
        }
        $data = $this->respondWithToken($token)->original['access_token'];
        $role  = auth()->user()->role->name;
        //KEMUDIAN KIRIM RESPONSENYA KE CLIENT UNTUK DIPROSES LEBIH LANJUT
        return response()->json([
            'status' => 'success', 
            'data' => $data, 
            'role' => $role,
        ], 200);
    }

    public function me()
    {
        $role  = auth()->user()->have_role->name;
        $name = auth()->user()->name;
        return response()->json(['role' => $role, 'name' => $name]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 999
        ]);
    }
}