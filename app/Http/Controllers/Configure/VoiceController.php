<?php

namespace App\Http\Controllers\Configure;

use Carbon\Carbon;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configure\VoiceModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Configure\VoiceFormRequest;

class VoiceController extends Controller
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
            ['title' => 'Voice', 'link' => route('voice.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Voice Setting | ' . env('APP_NAME'),
            'pageTitle' => 'Voice Setting',
            'breadCumbs' => $breadCumbs,
            'voice' => VoiceModel::first(),
        ];

        return view('configure.voice', $data);
    }

    public function store(VoiceFormRequest $request): RedirectResponse
    {
        // Check if data already exists
        $voice = VoiceModel::first();
        $formData = [
            'api_key' => Crypt::encrypt(htmlspecialchars($request->input('apiKey'))),
            'language' => htmlspecialchars($request->input('language')),
        ];
        $save = null;

        $directory = 'sounds/';

        if (!$voice) {
            // General validation request
            $request->validated();

            // If sound not exists
            $request->validate([
                'sound' => 'required',
            ], [
                'sound.required' => 'Sound file is required.',
            ]);

            // Upload file sound
            $fileSound = $request->file('sound');
            $hashNameFile = $fileSound->hashName();
            $uploadPath = $directory . $hashNameFile;
            $storeFile = $fileSound->storeAs($directory, $hashNameFile, 'public');
            if (!$storeFile) {
                return redirect()->back()->with('error', 'File sound failed to be uploaded !');
            }
            $formData['path_sound'] = $uploadPath;
            $save = VoiceModel::create($formData);
        } else {
            $fileSound = $request->file('sound');
            if ($fileSound) {
                // Delete old sound if exists
                if (Storage::disk('public')->exists($voice->path_sound)) {
                    Storage::disk('public')->delete($voice->path_sound);
                }

                $hashNameFile = $fileSound->hashName();
                $uploadPath = $directory . $hashNameFile;
                $storeFile = $fileSound->storeAs($directory, $hashNameFile, 'public');
                if (!$storeFile) {
                    return redirect()->back()->with('error', 'File sound failed to be uploaded !');
                }
                $formData['path_sound'] = $uploadPath;
            }
            $save = $voice->update($formData);
        }

        if (!$save) {
            return redirect()->back()->with('error', 'Failed to save voice settings!');
        }

        // Log the activity in the system
        LogModel::create([
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'activity' => Auth::user()->name . ' Saving voice settings ' . ' at ' . $this->carbon->now(),
        ]);

        return redirect()->route('voice.index')->with('success', 'Voice settings saved successfully.');
    }
}
