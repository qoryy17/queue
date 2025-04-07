<?php

namespace App\Http\Controllers\Officer;

use Illuminate\View\View;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Counter\CounterModel;
use App\Models\Officer\OfficerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Officer\OfficerFormRequest;

class OfficerController extends Controller
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
            ['title' => 'Officers', 'link' => route('officers.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Officers Manage' . env('APP_NAME'),
            'pageTitle' => 'Officers Manage',
            'breadCumbs' => $breadCumbs,
            'officers' => OfficerModel::with('counter')->orderBy('created_at', 'desc')->get(),
        ];

        return view('officer.officers', $data);
    }

    public function form(Request $request): RedirectResponse|View
    {
        // default breadcumbs
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Officers', 'link' => route('officers.index'), 'page' => '']
        ];

        // Checking parameters incoming
        if ($request->param == 'add') {
            $breadCumbs[] = ['title' => 'Add Officer', 'link' => route('officers.form', ['param' => 'add', 'id' => Crypt::encrypt('null')]), 'page' => 'aria-current="page"'];
            $pageTitle = 'Add Officer';
            $officer = null;
            $paramForm = Crypt::encrypt('save');
        } elseif ($request->param == 'edit') {
            $breadCumbs[] = ['title' => 'Edit Officer', 'link' => route('officers.form', ['param' => 'edit', 'id' => $request->id]), 'page' => 'aria-current="page"'];
            $pageTitle = 'Edit Officer';
            $officer = OfficerModel::findOrFail(Crypt::decrypt($request->id));
            $paramForm = Crypt::encrypt('update');
        } else {
            return redirect()->route('officers.index')->with('error', 'Invalid Request');
        }

        $data = [
            'title' => $pageTitle . ' ' . env('APP_NAME'),
            'pageTitle' => $pageTitle,
            'breadCumbs' => $breadCumbs,
            'officer' => $officer,
            'paramForm' => $paramForm,
            'counters' => CounterModel::where('status', '!=', 'Disabled')->orderBy('created_at', 'asc')->get(),
        ];

        // Redirect to form officer
        return view('officer.form-officers', $data);
    }

    public function store(OfficerFormRequest $request): RedirectResponse
    {
        // General validation request
        $request->validated();
        $paramForm = Crypt::decrypt($request->input('paramForm'));
        $save = null;

        $directory = '/officers/photos/';

        $formData = [
            'nip' => htmlspecialchars($request->input('nip')),
            'name' => htmlspecialchars($request->input('name')),
            'position' => htmlspecialchars($request->input('position')),
        ];

        if (htmlspecialchars($request->input('counter'))) {
            $formData['counter_id'] = htmlspecialchars($request->input('counter'));
        }

        if ($paramForm == 'save') {
            // Upload file photo if exists
            $filePhoto = $request->file('photo');
            if ($filePhoto) {
                $hashNameFile = $filePhoto->hashName();
                $uploadPath = $directory . $hashNameFile;
                $storeFile = $filePhoto->storeAs($directory, $hashNameFile, 'public');
                if (!$storeFile) {
                    return redirect()->back()->with('error', 'File photo failed to be uploaded !');
                }
                $formData['photo'] = $uploadPath;
            }
            // $formData['block']    = htmlspecialchars($request->input('block'));

            $save = OfficerModel::create($formData);
            $error = 'Officer failed to save !';
            $success = 'Officer saved successfully !';
            $activity = Auth::user()->name . ' created a new officer with name : ' . $formData['name'] . ' at ' . $this->carbon->now();
        } elseif ($paramForm == 'update') {
            $officer = OfficerModel::findOrFail(Crypt::decrypt($request->input('id')));
            if ($officer) {
                // Upload file photo
                $filePhoto = $request->file('photo');
                if ($filePhoto) {
                    // Delete old photo if exists
                    if ($officer->photo != null && Storage::disk('public')->exists($officer->photo)) {
                        Storage::disk('public')->delete($officer->photo);
                    }

                    $hashNameFile = $filePhoto->hashName();
                    $uploadPath = $directory . $hashNameFile;
                    $storeFile = $filePhoto->storeAs($directory, $hashNameFile, 'public');
                    if (!$storeFile) {
                        return redirect()->back()->with('error', 'File photo failed to be uploaded!');
                    }
                    $formData['photo'] = $uploadPath;
                }

                $formData['block'] = htmlspecialchars($request->input('block'));

                $save = $officer->update($formData);
                $error = 'Officer failed to update !';
                $success = 'Officer updated successfully !';
                $activity = Auth::user()->name . ' updated officer with name : ' . $formData['name'] . 'at ' . $this->carbon->now();
            } else {
                return redirect()->route('officers.index')->with('error', 'Officer not found!')->withInput();
            }
        } else {
            return redirect()->route('officers.index')->with('error', 'Invalid Request!')->withInput();
        }

        // Check if the save was successful
        if (!$save) {
            return redirect()->route('officers.index')->with('error', $error)->withInput();
        }

        // Log the activity in the system
        LogModel::create([
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'activity' => $activity,
        ]);

        // Redirect to the index page with success message
        return redirect()->route('officers.index')->with('success', $success);

    }

    public function destroy(Request $request): RedirectResponse
    {
        $searchOfficer = OfficerModel::findOrFail(Crypt::decrypt($request->id));
        if ($searchOfficer) {
            // Delete old photo if exists
            if (Storage::disk('public')->exists($searchOfficer->photo)) {
                Storage::disk('public')->delete($searchOfficer->photo);
            }
            // Log the activity in the system
            LogModel::create([
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' deleted officer ' . $searchOfficer->name . ' at ' . $this->carbon->now()
            ]);
            $searchOfficer->delete();
            return redirect()->route('officers.index')->with('success', 'Officer deleted successfully');
        } else {
            return redirect()->route('officers.index')->with('error', 'Officer not found');
        }
    }

    public function show(Request $request)
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Officers', 'link' => route('officers.index'), 'page' => ''],
            ['title' => 'Show Officer', 'link' => route('officers.show', ['id' => $request->id]), 'page' => 'aria-current="page"']
        ];

        $officer = OfficerModel::with('counter')->findOrFail(Crypt::decrypt($request->id));
        if (!$officer) {
            return redirect()->route('officers.index')->with('error', 'Officer not found');
        }

        $data = [
            'title' => $officer->name . ' ' . env('APP_NAME'),
            'pageTitle' => $officer->name,
            'breadCumbs' => $breadCumbs,
            'officer' => $officer
        ];

        return view('officer.show-officers', $data);
    }

}
