<?php

namespace App\Http\Controllers\Configure;

use Carbon\Carbon;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Configure\SettingModel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Configure\SettingFormRequest;

class SettingController extends Controller
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
            ['title' => 'Application', 'link' => route('setting.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Application Setting | ' . env('APP_NAME'),
            'pageTitle' => 'Application Setting',
            'breadCumbs' => $breadCumbs,
            'setting' => SettingModel::first()
        ];

        return view('configure.setting', $data);
    }

    public function store(SettingFormRequest $request): RedirectResponse
    {
        // General validation request
        $setting = SettingModel::first();
        $request->validated();
        $formData = [
            'institution' => htmlspecialchars($request->input('institution')),
            'eselon' => htmlspecialchars($request->input('eselon')),
            'jurisdiction' => htmlspecialchars($request->input('jurisdiction')),
            'unit' => htmlspecialchars($request->input('unit')),
            'address' => htmlspecialchars($request->input('address')),
            'province' => htmlspecialchars($request->input('province')),
            'postCode' => htmlspecialchars($request->input('postCode')),
            'email' => htmlspecialchars($request->input('email')),
            'website' => htmlspecialchars($request->input('website')),
            'contact' => htmlspecialchars($request->input('contact')),
        ];

        $save = null;
        $directory = 'logo/';

        if (!$setting) {
            // If logo not exists
            $request->validate([
                'logo' => 'required'
            ], [
                'logo.required' => 'Logo is required.'
            ]);

            // Upload file logo
            $fileLogo = $request->file('logo');
            $hashNameFile = $fileLogo->hashName();
            $uploadPath = $directory . $hashNameFile;
            $storeFile = $fileLogo->storeAs($directory, $hashNameFile, 'public');
            if (!$storeFile) {
                return redirect()->back()->with('error', 'File logo failed to be uploaded !');
            }
            $formData['logo'] = $uploadPath;
            $save = SettingModel::create($formData);
        } else {
            if ($request->file('logo')) {
                // Delete old logo if exists
                if (Storage::disk('public')->exists($setting->logo)) {
                    Storage::disk('public')->delete($setting->logo);
                }

                $fileLogo = $request->file('logo');
                $hashNameFile = $fileLogo->hashName();
                $uploadPath = $directory . $hashNameFile;
                $storeFile = $fileLogo->storeAs($directory, $hashNameFile, 'public');
                if (!$storeFile) {
                    return redirect()->back()->with('error', 'File logo failed to be uploaded !');
                }
                $formData['logo'] = $uploadPath;
            }
            $save = $setting->update($formData);

        }

        if (!$save) {
            return redirect()->back()->with('error', 'Failed to save application settings!');
        }

        // Log the activity in the system
        LogModel::create([
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'activity' => Auth::user()->name . ' Saving application settings ' . ' at ' . $this->carbon->now(),
        ]);

        return redirect()->route('setting.index')->with('success', 'Application settings saved successfully.');
    }
}
