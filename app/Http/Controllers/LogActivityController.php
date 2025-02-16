<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Catatan Aktivitas';

        if ($request->ajax()) {
            $model = Activity::with('causer');
            return DataTables::of($model)
                ->make(true);
        }
        return view('log-activity.index', compact('title'));
    }
}
