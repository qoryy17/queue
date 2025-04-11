<?php

namespace App\Http\Controllers;

use App\Models\Configure\SettingModel;
use App\Models\Configure\VoiceModel;
use App\Models\Counter\CounterModel;

class HomeScreenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => env('APP_NAME'),
            'navbarTitle' => env('APP_NAME'),
            'counters' => CounterModel::where('status', 'Open')->orderBy('code', 'ASC'),
            'voice' => VoiceModel::first(),
            'config' => SettingModel::first()
        ];

        return view('print.home-screen', $data);
    }

}
