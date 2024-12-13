<?php


use Illuminate\Support\Facades\Route;
use MohsenMhm\LaravelTracking\Http\Controllers\RequestTrackerController;
use MohsenMhm\LaravelTracking\Http\Middleware\CheckTrackingPermission;

Route::middleware(config('tracking.middleware'))->group(function () {
    Route::get(config('tracking.route_url', 'request-logs'), [RequestTrackerController::class, 'index'])
        ->middleware([CheckTrackingPermission::class])->name('request.logs');
});