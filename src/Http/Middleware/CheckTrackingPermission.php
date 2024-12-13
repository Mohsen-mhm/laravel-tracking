<?php

namespace MohsenMhm\LaravelTracking\Http\Middleware;

use Closure;

class CheckTrackingPermission
{
    public function handle($request, Closure $next)
    {
        // Check permission dynamically
        $permission = config('tracking.permission');
        if ($permission && !auth()->user()->can($permission)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}