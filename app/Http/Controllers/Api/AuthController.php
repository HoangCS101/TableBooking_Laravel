<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $request->authenticate(); // Call authenticate() to handle authentication

            $token = $request->user()->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
