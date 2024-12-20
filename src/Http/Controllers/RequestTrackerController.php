<?php

namespace MohsenMhm\LaravelTracking\Http\Controllers;

use Illuminate\Http\Request;
use MohsenMhm\LaravelTracking\Models\TrackingLog;
use App\Http\Controllers\Controller;

class RequestTrackerController extends Controller
{
    public function index(Request $request)
    {
        $query = TrackingLog::query();

        // Search functionality
        if ($search = strtolower($request->input('search'))) {
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(url) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(method) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(ip_address) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(user_agent) LIKE ?', ["%{$search}%"]);
            });
        }

        $logs = $query->with('user')->latest()->paginate(15);
        return view('request-tracker::index', compact('logs'));
    }

    public function destroy(TrackingLog $log)
    {
        $log->delete();
        
        return back()->with('success', 'Log deleted successfully');
    }

    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
        TrackingLog::whereIn('id', $ids)->delete();
        
        return back()->with('success', count($ids) . ' logs deleted successfully');
    }
}