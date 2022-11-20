<?php

namespace Modules\Main\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAjaxRequest
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Check if the route is an ajax request only route
        if (!$request->ajax()) {
            return abort(404);
        }
        return $next($request);
    }
}
