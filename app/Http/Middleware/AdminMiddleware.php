<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
        $whitelistIP = explode(';', env('WHITELIST_IP'));
        $whitelistIPS = preg_match("/^" . implode("|", $whitelistIP) . "/", $_SERVER["REMOTE_ADDR"]);
        if (!$whitelistIPS) {
            return abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
