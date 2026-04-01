<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Giriş tələb olunur'
            ], 401);
        }

        $allowed = array_map(fn(string $r) => Role::from($r), $roles);

        if (!$user->hasRole(...$allowed)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu əməliyyat üçün icazəniz yoxdur'
            ], 403);
        }

        return $next($request);
    }
}
