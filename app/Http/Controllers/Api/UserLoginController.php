<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserLoginController extends Controller
{
    // Register
public function register(Request $request)
{
    $validated = $request->validate([
        "name" => "nullable|string|max:255",
        "email" => "required|email|unique:user_logins,email",
        "password" => "required|min:6",
    ]);

    $user = UserLogin::create([
        "name" => $validated["name"],
        "email" => $validated["email"],
        "password" => Hash::make($validated["password"]),
        "api_token" => base64_encode(str()->random(40)), // generate once
    ]);

    return response()->json([
        "success" => true,
        "message" => "User registered successfully",
        "token" => $user->api_token,  // ✅ send token
        "user" => $user
    ]);
}


    // Login
public function login(Request $request)
{
    $validated = $request->validate([
        "email" => "required|email",
        "password" => "required",
    ]);

    $user = UserLogin::where("email", $validated["email"])->first();

    if (!$user || !Hash::check($validated["password"], $user->password)) {
        return response()->json([
            "success" => false,
            "message" => "Invalid credentials"
        ], 401);
    }

    // 🔥 Do NOT regenerate token — keep it fixed forever
    $token = $user->api_token;

    return response()->json([
        "success" => true,
        "message" => "Login successful",
        "token" => $token,
        "user" => $user
    ]);
}


    // List users
    public function index()
    {
        return UserLogin::latest()->get();
    }
}
