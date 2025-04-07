<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeScreenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => env('APP_NAME'),
            'navbarTitle' => env('APP_NAME'),
        ];
        return view('print.home-screen', $data);
    }

}
