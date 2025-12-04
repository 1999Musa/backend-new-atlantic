<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLogin;

class ApiToken
{
public function handle($request, Closure $next)
{
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json(['error' => 'Missing token'], 401);
    }

    $user = UserLogin::where('api_token', $token)->first();

    if (!$user) {
        return response()->json(['error' => 'Invalid token'], 401);
    }

    // 🔥 Attach user properly
    $request->setUserResolver(function() use ($user) {
        return $user;
    });

    return $next($request);
}


}
