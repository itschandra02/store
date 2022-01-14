<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('Authorization')) {
            return response()->json([
                'error' => 'No token provided.'
            ], 401);
        }
        $apikey = $request->header('Authorization');
        $userApikey = DB::table('users')->where('apikey', $apikey)->first();
        if (!$userApikey) {
            return response()->json([
                'error' => 'Invalid token.'
            ], 401);
        }
        return $next($request);
    }
}
