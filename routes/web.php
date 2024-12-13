<?php


use Illuminate\Support\Facades\Route;
use MohsenMhm\LaravelTracking\Http\Controllers\RequestTrackerController;

Route::get(config('tracking.route_url', 'request-logs'), [RequestTrackerController::class, 'index'])->name('request.logs');