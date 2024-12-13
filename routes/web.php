<?php


use Illuminate\Support\Facades\Route;
use MohsenMhm\LaravelTracking\Http\Controllers\RequestTrackerController;
use MohsenMhm\LaravelTracking\Http\Middleware\CheckTrackingPermission;

Route::get(config('tracking.route_url', 'request-logs'), [RequestTrackerController::class, 'index'])
    ->middleware([config('tracking.middleware'), CheckTrackingPermission::class])->name('request.logs');
