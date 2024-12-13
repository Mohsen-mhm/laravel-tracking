<?php

namespace MohsenMhm\LaravelTracking\Http\Middleware;

use Closure;
use MohsenMhm\LaravelTracking\Services\TrackingService;

class TrackRequests
{
    public function handle($request, Closure $next)
    {
        if (!config('requesttracker.logging_enabled')) {
            return $next($request);
        }

        $response = $next($request);

        // Collect data based on configuration
        $logData = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_id' => config('requesttracker.log_user') ? Auth::id() : null,
            'ip_address' => config('requesttracker.log_ip') ? $request->ip() : null,
            'user_agent' => config('requesttracker.log_user_agent') ? $request->header('User-Agent') : null,
            'response_status' => $response->status(),
        ];

        if (config('requesttracker.log_headers')) {
            $logData['headers'] = json_encode($request->headers->all());
        }

        if (config('requesttracker.log_body')) {
            $logData['body'] = json_encode($request->all());
        }

        if (config('requesttracker.log_response')) {
            $logData['response_content'] = $response->getContent();
        }

        RequestLog::create($logData);

        return $response;
    }
}