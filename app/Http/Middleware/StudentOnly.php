<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); // يعتمد على التوكن من Sanctum

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized, please login.'
            ], 401);
        }

        if ($user->user_role !== 'student') {
            return response()->json([
                'status' => false,
                'message' => 'Access denied, students only.'
            ], 403);
        }

        return $next($request);
    }
}
