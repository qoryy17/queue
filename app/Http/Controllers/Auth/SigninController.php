<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SigninController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Sign In | ' . env('APP_NAME')
        ];

        return view('auth.signin', $data);
    }
}
