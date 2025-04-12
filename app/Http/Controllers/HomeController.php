<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\ConfigTime;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use App\Models\Configure\VoiceModel;
use App\Models\Counter\CounterModel;
use App\Models\Officer\OfficerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\ProfileRequest;
use App\Models\Queue\QueueLogModel;

class HomeController extends Controller
{
    protected $route;
    protected $carbon;

    public function __construct()
    {
        $this->route = RouterLink::string(Auth::user()->role);
        $this->carbon = new Carbon();
        $this->carbon->setTimezone(env('APP_TIMEZONE'));
    }

    public function countQueue($status = null)
    {
        return QueueLogModel::where('status', $status)->count();
    }
    public function indexAdmin()
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => '#', 'page' => ''],
            ['title' => 'Home', 'link' => route($this->route), 'page' => 'aria-current="page"'],
        ];

        $data = [
            'title' => 'Home | ' . env('APP_NAME'),
            'pageTitle' => ConfigTime::time() . ' ' . Auth::user()->name,
            'breadCumbs' => $breadCumbs,
            'voice' => VoiceModel::first(),
            'queueCompleted' => $this->countQueue('Completed'),
            'queueSkipped' => $this->countQueue('Skipped'),

        ];
        return view('home.home-admin', $data);
    }

    public function indexOfficer()
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => '#', 'page' => ''],
            ['title' => 'Home', 'link' => route($this->route), 'page' => 'aria-current="page"'],
        ];

        $counter = OfficerModel::findOrFail(Auth::user()->officer_id)->counter()->first();

        $data = [
            'title' => 'Home | ' . env('APP_NAME'),
            'pageTitle' => ConfigTime::time() . ' ' . Auth::user()->name,
            'breadCumbs' => $breadCumbs,
            'counter' => $counter,
            'queueCompleted' => $this->countQueue('Completed'),
            'queueSkipped' => $this->countQueue('Skipped'),
        ];
        return view('home.home-officer', $data);
    }

    public function storePassword(Request $request): RedirectResponse
    {
        // Validate password
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'string',
            ],
        ], [
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
        ]);

        $formData = [
            'password' => Hash::make(htmlspecialchars($request->input('password'))),
        ];

        $searchUser = User::findOrFail(Auth::user()->id);

        $save = $searchUser->update($formData);
        if (!$save) {
            return redirect()->back()->with('error', 'Password failed to be updated !');
        }

        Auth::logout();
        $request->session()->regenerate();
        return redirect()->route('signin')->with('success', 'Password success for updated, you must login again !');
    }

    public function profile()
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Profile', 'link' => '', 'page' => 'aria-current="page"'],
        ];

        $profile = User::with('officer')->findOrFail(Auth::user()->officer_id);
        $counter = CounterModel::findOrFail($profile->officer->counter_id);

        $data = [
            'title' => 'Home | ' . env('APP_NAME'),
            'pageTitle' => ConfigTime::time() . ' ' . Auth::user()->name,
            'breadCumbs' => $breadCumbs,
            'profile' => $profile,
            'counter' => $counter
        ];
        return view('profile.profile-account', $data);
    }

    public function storeProfile(ProfileRequest $request)
    {
        // General validation request
        $request->validated();

        // Search user form database
        $user = User::findOrFail(Auth::user()->id);

        // Search officer form database
        $officer = OfficerModel::findOrFail(Auth::user()->officer_id);

        $formDataUser = [
            'email' => htmlspecialchars($request->input('email')),
            'name' => htmlspecialchars($request->input('name')),
        ];

        $formDataOfficer = [
            'nip' => htmlspecialchars($request->input('nip')),
            'name' => htmlspecialchars($request->input('name')),
        ];

        $directory = '/officers/photos/';

        $filePhoto = $request->file('photo');
        if ($filePhoto) {
            if ($officer) {
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
                $formDataOfficer['photo'] = $uploadPath;
            }
        }

        $saveOfficer = $officer->update($formDataOfficer);
        $saveUser = $user->update($formDataUser);
        if ($saveOfficer & $saveUser) {
            // Save activity and back to redirect
            $activity = Auth::user()->name . ' updated profile : ' . $formDataOfficer['name'] . 'at ' . $this->carbon->now();
            LogModel::create([
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => $activity,
            ]);
            return redirect()->route('profile.index')->with('success', 'Update profile success !');
        }

        return redirect()->back()->with('error', 'Update profile failed !');
    }
}
