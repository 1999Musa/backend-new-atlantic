<?php


namespace App\Http\Middleware;

use Closure;
use App\Models\UserLogin;

class TokenAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken(); // read Authorization: Bearer TOKEN

        if (!$token) {
            return response()->json(['error' => 'Token is missing'], 401);
        }

        $user = UserLogin::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // attach user to request
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
