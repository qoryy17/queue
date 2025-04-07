<?php

namespace App\Http\Controllers\Queue;

use Carbon\Carbon;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use App\Models\Queue\QueueLogModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class QueueLogController extends Controller
{
    protected $route;
    protected $carbon;

    public function __construct()
    {
        $this->route = RouterLink::string(Auth::user()->role);

        $this->carbon = new Carbon();
        $this->carbon->setTimezone(env('APP_TIMEZONE'));
    }
    public function index()
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Queue', 'link' => route('queue-logs.index'), 'page' => 'aria-current="page"']
        ];

        // Check if the cache for queue logs exists
        $queueLogs = Cache::remember('queue_logs', 3600, function () {
            return QueueLogModel::orderBy('created_at', 'desc')->get();
        });

        $data = [
            'title' => 'Queue Logs | ' . env('APP_NAME'),
            'pageTitle' => 'Queue Logs',
            'breadCumbs' => $breadCumbs,
            'queueLogs' => $queueLogs,
        ];

        return view('queue.queue-logs', $data);
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

        $deleteQueue = QueueLogModel::whereBetween('created_at', [$firstDate, $endDate]);

        if ($deleteQueue->exists()) {
            // Log the activity in the system
            LogModel::create([
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' Deleted queue logs from first date : ' . $firstDate . ' to end date : ' . $endDate . ' at ' . $this->carbon->now()
            ]);
            $deleteQueue->delete();
            // Clear the cache for queue logs list to reflect the changes
            Cache::forget('queue_logs');
            return redirect()->route('queue-logs.index')->with('success', 'Queue logs deleted successfully');
        }
        return redirect()->route('queue-logs.index')->with('error', 'Queue logs failed to delete');
    }
}
