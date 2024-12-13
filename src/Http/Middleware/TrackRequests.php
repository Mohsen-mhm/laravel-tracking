<?php

namespace MohsenMhm\LaravelTracking\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use MohsenMhm\LaravelTracking\Models\TrackingLog;
use MohsenMhm\LaravelTracking\Services\TrackingService;

class TrackRequests
{
    public function handle($request, Closure $next)
    {
        if (!config('tracking.logging_enabled')) {
            return $next($request);
        }

        $response = $next($request);

        // Collect data based on configuration
        $logData = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_id' => config('tracking.log_user') ? Auth::id() : null,
            'ip_address' => config('tracking.log_ip') ? $request->ip() : null,
            'user_agent' => config('tracking.log_user_agent') ? $request->header('User-Agent') : null,
            'response_status' => $response->status(),
        ];

        if (config('tracking.log_headers')) {
            $logData['headers'] = json_encode($request->headers->all());
        }

        if (config('tracking.log_body')) {
            $logData['body'] = json_encode($request->all());
        }

        if (config('tracking.log_response')) {
            $logData['response_content'] = $response->getContent();
        }

        TrackingLog::query()->create($logData);

        return $response;
    }
}