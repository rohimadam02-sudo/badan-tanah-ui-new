<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 20);
        
        $activities = Activity::with('causer')
            ->latest()
            ->paginate($limit);

        return view('admin.activity_log', compact('activities'));
    }

    public function filter(Request $request)
    {
        $query = Activity::with('causer');

        if ($request->event) {
            $query->where('event', $request->event);
        }

        if ($request->log_name) {
            $query->where('log_name', $request->log_name);
        }

        $activities = $query->latest()->paginate(20);

        return view('admin.activity_log', compact('activities'));
    }
}