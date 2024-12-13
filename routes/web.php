<?php


use Illuminate\Support\Facades\Route;
use MohsenMhm\LaravelTracking\Http\Controllers\RequestTrackerController;

Route::group([
    'middleware' => config('tracking.middleware'),
], function () {
    Route::get(config('tracking.route_url', 'request-logs'), [RequestTrackerController::class, 'index'])
        ->middleware(function ($request, $next) {
            // Check permission dynamically
            $permission = config('tracking.permission');
            if ($permission && !auth()->user()->can($permission)) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        })->name('request.logs');
});