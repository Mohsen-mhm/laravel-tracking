<?php

namespace MohsenMhm\LaravelTracking\Http\Controllers;

use MohsenMhm\LaravelTracking\Models\TrackingLog;
use App\Http\Controllers\Controller;

class RequestTrackerController extends Controller
{
    public function index()
    {
        $logs = TrackingLog::with('user')->latest()->paginate(10);
        return view('request-tracker::index', compact('logs'));
    }
}