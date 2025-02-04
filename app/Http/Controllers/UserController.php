<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\JsonResponse;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    $validator = Validator::make($credentials, [
        'email' => 'required|email',
        'password' => 'required|string|min:6'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    try {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
    } catch (JWTException $e) {
        return response()->json(['error' => 'Could not create token'], 500);
    }

    return response()->json(['token' => $token]);
});

Route::post('/register', function (Request $request) {
    $data = $request->only('name', 'email', 'password');

    $validator = Validator::make($data, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json(['token' => $token, 'user' => $user]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json($request->user());
});
