<?php

namespace MohsenMhm\LaravelTracking\Services;

use Illuminate\Support\Facades\Auth;
use MohsenMhm\LaravelTracking\Models\TrackingLog;

class TrackingService
{
    public function logRequest($request, $response): void
    {
        TrackingLog::query()->create([
            'user_id' => Auth::id(),
            'url' => $request->url(),
            'method' => $request->method(),
            'request_data' => json_encode($request->all()),
            'response_data' => json_encode($response->getContent()),
        ]);
    }
}