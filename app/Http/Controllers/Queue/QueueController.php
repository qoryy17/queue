<?php

namespace App\Http\Controllers\Queue;

use Carbon\Carbon;
use App\Helpers\RouterLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Officer\OfficerModel;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    protected $route;
    protected $carbon;
    public function __construct()
    {
        // Constructor logic if needed
        $this->route = RouterLink::string(Auth::user()->role);
        $this->carbon = new Carbon();
        $this->carbon->setTimezone(env('APP_TIMEZONE'));
    }
    public function index()
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Queue', 'link' => route('queues.index'), 'page' => 'aria-current="page"'],
        ];

        $counter = OfficerModel::findOrFail(Auth::user()->officer_id)->counter()->first();
        if ($counter->status === \App\Enum\CounterEnum::DISABLED->value) {
            return redirect()->route($this->route)->with('error', 'Counter is disabled, please contact Administrator for enabled');
        }

        $data = [
            'title' => 'Queue Counter ' . $counter->name . ' | ' . env('APP_NAME'),
            'pageTitle' => 'Queue Counter ' . $counter->name,
            'breadCumbs' => $breadCumbs,
        ];
        return view('queue.queues', $data);
    }
}
