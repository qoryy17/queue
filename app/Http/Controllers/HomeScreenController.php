<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter\CounterModel;

class HomeScreenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => env('APP_NAME'),
            'navbarTitle' => env('APP_NAME'),
            'counters' => CounterModel::where('status', 'Open')->orderBy('code', 'ASC')
        ];

        return view('print.home-screen', $data);
    }

}
