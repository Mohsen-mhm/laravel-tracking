<?php

namespace MohsenMhm\LaravelTracking\Http\Controllers;

use Illuminate\Http\Request;
use MohsenMhm\LaravelTracking\Models\TrackingLog;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class RequestTrackerController extends Controller
{
    public function index(Request $request)
    {
        $query = TrackingLog::query();

        // Basic search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('url', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('user_agent', 'like', "%{$search}%");
            });
        }

        // Method filter
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('response_status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // IP filter
        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', "%{$request->ip}%");
        }

        // User filter (manually fetch matching user IDs)
        if ($request->filled('user')) {
            $searchTerm = strtolower($request->user);

            if ($searchTerm === 'guest') {
                $query->whereNull('user_id');
            } else {
                $columns = Schema::getColumnListing('users');

                $users = User::on('mysql')
                    ->where(function ($q) use ($columns, $searchTerm) {
                        foreach ($columns as $column) {
                            if (in_array($column, ['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at'])) {
                                continue;
                            }

                            $q->orWhereRaw("LOWER(CAST({$column} AS TEXT)) LIKE ?", ["%{$searchTerm}%"]);
                        }
                    })->pluck('id');

                $query->whereIn('user_id', $users);
            }
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        // Attach user info from separate DB
        foreach ($logs as $log) {
            $log->user = $log->resolvedUser();
        }

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