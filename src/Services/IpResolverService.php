<?php

namespace MohsenMhm\LaravelTracking\Services;

use Illuminate\Http\Request;

class IpResolverService
{
    public function resolveIp(Request $request): ?string
    {
        // Check if custom resolver is configured
        $customResolver = config('tracking.ip_resolver');
        
        if (is_callable($customResolver)) {
            return call_user_func($customResolver, $request);
        }
        
        // Default IP resolution logic
        return $request->ip();
    }
} 