<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */

     public function store(LoginRequest $request): JsonResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token
    ], 200);
}

    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete(); // Revoke all tokens for the user
        }

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}
