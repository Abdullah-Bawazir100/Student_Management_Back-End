<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); // يستخدم التوكن

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized, please login.'
            ], 401);
        }

        if ($user->user_role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Access denied, admin only.'
            ], 403);
        }

        return $next($request);
    }
}
