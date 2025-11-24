<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    // Return logged-in user data
    public function show(Request $request)
    {
        return response()->json([
            "success" => true,
            "user" => $request->auth_user,
        ]);
    }

    // Update name + email
    public function updateProfile(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $request->auth_user->id,
        ]);

        $user = $request->auth_user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            "success" => true,
            "message" => "Profile updated successfully",
            "user" => $user
        ]);
    }

    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            "current_password" => "required",
            "new_password" => "required|min:6",
        ]);

        $user = $request->auth_user;

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                "success" => false,
                "message" => "Current password is incorrect"
            ], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            "success" => true,
            "message" => "Password updated successfully"
        ]);
    }
}
