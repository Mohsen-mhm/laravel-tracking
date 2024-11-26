<?php

namespace MohsenMhm\LaravelTracking\Http\Middleware;

use Closure;
use MohsenMhm\LaravelTracking\Services\TrackingService;

class TrackRequests
{
    public function __construct(
        protected TrackingService $trackingService
    )
    {
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (config('tracking.enabled')) {
            $this->trackingService->logRequest($request, $response);
        }

        return $response;
    }
}