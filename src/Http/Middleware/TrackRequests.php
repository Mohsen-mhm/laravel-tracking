<?php

namespace MohsenMhm\LaravelTracking\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use MohsenMhm\LaravelTracking\Models\TrackingLog;
use MohsenMhm\LaravelTracking\Services\IpResolverService;

class TrackRequests
{
    protected IpResolverService $ipResolver;

    public function __construct(IpResolverService $ipResolver)
    {
        $this->ipResolver = $ipResolver;
    }

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
            'ip_address' => config('tracking.log_ip') ? $this->ipResolver->resolveIp($request) : null,
            'user_agent' => config('tracking.log_user_agent') ? $request->header('User-Agent') : null,
            'response_status' => $response->status(),
        ];

        if (config('tracking.log_headers')) {
            $logData['headers'] = json_encode($request->headers->all());
        }

        if (config('tracking.log_body')) {
            $requestData = $request->all();
            
            // Remove file fields from request data
            foreach ($requestData as $key => $value) {
                if ($request->hasFile($key)) {
                    unset($requestData[$key]);
                }
            }
            
            $logData['body'] = json_encode($requestData);
        }

        TrackingLog::query()->create($logData);

        return $response;
    }
}