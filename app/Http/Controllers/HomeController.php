<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\ConfigTime;
use App\Helpers\RouterLink;
use App\Models\Configure\VoiceModel;
use App\Models\Officer\OfficerModel;
use Illuminate\Support\Facades\Auth;

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
            'voice' => VoiceModel::first()
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
        ];
        return view('home.home-officer', $data);
    }
}
