<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
/**
 * @OA\Info(title="My First API", version="0.1")
 */
class AuthController extends Controller
{
    /**
 * @SWG\Post(
 *     path="/AUTH",
 *     summary="Register User",
 *     tags={"Users"},
 *     @SWG\Response(response=201, description="Successful operation"),
 *     @SWG\Response(response=400, description="Invalid request")
 * )
 */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
 * @SWG\Post(
 *     path="/AUTH",
 *     summary="Login User",
 *     tags={"Users"},
 *     @SWG\Response(response=200, description="Successful operation"),
 *     @SWG\Response(response=400, description="Invalid request")
 * )
 */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json(["email" => $request->email,'token' => $token]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
