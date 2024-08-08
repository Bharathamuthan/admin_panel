<?php

namespace App\Http\Middleware;

use Closure;

class AjaxMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'false', 'message' => 'Access only ajax request'], 403);
        }

        return $next($request);
    }
}
