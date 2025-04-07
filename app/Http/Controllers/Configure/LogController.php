<?php

namespace App\Http\Controllers\Configure;

use Carbon\Carbon;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class LogController extends Controller
{
    protected $route;

    public function __construct()
    {
        $this->route = RouterLink::string(Auth::user()->role);
    }
    public function index()
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Logs Activity', 'link' => route('logs.index'), 'page' => 'aria-current="page"']
        ];

        // Check if the cache for logs activity exists
        $logs = Cache::remember('logs_activity', 3600, function () {
            return LogModel::orderBy('created_at', 'desc')->get();
        });

        $data = [
            'title' => 'Logs Activity | ' . env('APP_NAME'),
            'pageTitle' => 'Logs Activity',
            'breadCumbs' => $breadCumbs,
            'logs' => $logs
        ];

        return view('configure.logs', $data);
    }

    public function destroy(Request $request): RedirectResponse
    {
        // General validation request
        $request->validate([
            'firstDate' => 'required|date_format:m/d/Y',
            'endDate' => 'required|date_format:m/d/Y|after_or_equal:firstDate',
        ], [
            'firstDate.required' => 'First date must be selected !',
            'firstDate.date_format' => 'First date must be in format m/d/Y !',
            'firstDate.after_or_equal' => 'First date must be before or equal to end date !',
            'endDate.date_format' => 'End date must be in format m/d/Y !',
            'endDate.after_or_equal' => 'End date must be after or equal to first date !',
        ]);

        $firstDate = Carbon::createFromFormat('m/d/Y', htmlentities($request->input('firstDate')))->startOfDay();
        $endDate = Carbon::createFromFormat('m/d/Y', htmlentities($request->input('endDate')))->endOfDay();

        $deleteLogs = LogModel::whereBetween('created_at', [$firstDate, $endDate]);

        if ($deleteLogs->exists()) {
            $deleteLogs->delete();
            // Clear the cache for logs activity
            Cache::forget('logs_activity');
            return redirect()->route('logs.index')->with('success', 'Logs activity deleted successfully');
        }
        return redirect()->route('logs.index')->with('error', 'Logs activity failed to delete');
    }
}
