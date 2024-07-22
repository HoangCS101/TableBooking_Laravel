<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
        ]);
        if ($validated->fails()) return response()->json(['errors' => $validated->errors()], 422);
        
        $user = auth('sanctum')->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // return auth('sanctum')->user();
        return response()->json([
            'message' => 'Profile updated successfully',
            'update user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
        ], [
            'current_password.required' => 'The current_password field is required.',
            'new_password.required' => 'The new_password field is required.',
            'new_password.min:8' => 'The new_password field must be greate than 8 characters.',
        ]);
        if ($validated->fails()) return response()->json(['errors' => $validated->errors()], 422);

        $user = auth('sanctum')->user();
        // return response()->json(['message' => $user->password], 200);
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 401);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }

    public function delete(Request $request)
    {
        $token = $request->bearerToken();

        $user = auth('sanctum')->user();
        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'Account with token ' . $token . ' deleted successfully']);
    }

    public function get(Request $request)
    {
        return auth('sanctum')->user();
        // return $request->user();
    }
}
