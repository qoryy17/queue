<?php

namespace App\Http\Controllers\Counter;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Counter\CounterModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\Counter\CounterFormRequest;

class CounterController extends Controller
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
            ['title' => 'Counters', 'link' => route('counters.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Counters Manage' . env('APP_NAME'),
            'pageTitle' => 'Counters Manage',
            'breadCumbs' => $breadCumbs,
            'counters' => CounterModel::orderBy('created_at', 'desc')->get(),
        ];

        return view('counter.counters', $data);
    }

    public function form(Request $request): RedirectResponse|View
    {
        // default breadcumbs
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Counters', 'link' => route('counters.index'), 'page' => '']
        ];

        // Checking parameters incoming
        if ($request->param == 'add') {
            $breadCumbs[] = ['title' => 'Add Counter', 'link' => route('counters.form', ['param' => 'add', 'id' => Crypt::encrypt('null')]), 'page' => 'aria-current="page"'];
            $pageTitle = 'Add Counter';
            $counter = null;
            $paramForm = Crypt::encrypt('save');
        } elseif ($request->param == 'edit') {
            $breadCumbs[] = ['title' => 'Edit Counter', 'link' => route('counters.form', ['param' => 'edit', 'id' => $request->id]), 'page' => 'aria-current="page"'];
            $pageTitle = 'Edit Counter';
            $counter = CounterModel::findOrFail(Crypt::decrypt($request->id));
            $paramForm = Crypt::encrypt('update');
        } else {
            return redirect()->route('counters.index')->with('error', 'Invalid Request');
        }

        $data = [
            'title' => $pageTitle . ' ' . env('APP_NAME'),
            'pageTitle' => $pageTitle,
            'breadCumbs' => $breadCumbs,
            'counter' => $counter,
            'paramForm' => $paramForm,
        ];

        // Redirect to form counter
        return view('counter.form-counter', $data);
    }

    public function store(CounterFormRequest $request): RedirectResponse
    {
        // Check if the request is for saving or updating
        $request->validated();
        $paramForm = Crypt::decrypt($request->input('paramForm'));
        $save = null;

        $formData = [
            'code' => htmlspecialchars($request->input('code')),
            'name' => htmlspecialchars($request->input('name')),
            'description' => htmlspecialchars($request->input('description')),
            'status' => htmlspecialchars($request->input('status')),
        ];

        if ($paramForm == 'save') {
            $save = CounterModel::create($formData);
            $error = 'Counter failed to save !';
            $success = 'Counter saved successfully !';
            $activity = Auth::user()->name . ' created a new counter with code ' . $formData['code'] . ' at ' . $this->carbon->now();
        } elseif ($paramForm == 'update') {
            $counter = CounterModel::findOrFail(Crypt::decrypt($request->input('id')));
            if ($counter) {
                $save = $counter->update($formData);
                $error = 'Counter failed to update !';
                $success = 'Counter updated successfully !';
                $activity = Auth::user()->name . ' updated the counter with code ' . $formData['code'] . ' at ' . $this->carbon->now();
            } else {
                return redirect()->route('counters.index')->with('error', 'Counter not found')->withInput();
            }
        } else {
            return redirect()->route('counters.index')->with('error', 'Invalid Request')->withInput();
        }

        // Check if the save was successful
        if (!$save) {
            return redirect()->route('counters.index')->with('error', $error)->withInput();
        }

        // Log the activity in the system
        LogModel::create([
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'activity' => $activity,
        ]);

        // Redirect to the index page with success message
        return redirect()->route('counters.index')->with('success', $success);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $searchCounter = CounterModel::findOrFail(Crypt::decrypt($request->id));
        if ($searchCounter) {
            // Log the activity in the system
            LogModel::create([
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' deleted counter ' . $searchCounter->name . ' at ' . $this->carbon->now()
            ]);
            $searchCounter->delete();
            return redirect()->route('counters.index')->with('success', 'Counter deleted successfully');
        } else {
            return redirect()->route('counters.index')->with('error', 'Counter not found');
        }
    }
}
