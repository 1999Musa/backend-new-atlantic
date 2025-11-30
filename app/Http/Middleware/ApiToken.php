<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLogin;

class ApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }

        $token = str_replace('Bearer ', '', $token);

        $user = UserLogin::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Attach the authenticated user
        $request->setUserResolver(fn() => $user);

        return $next($request);
    }
}
