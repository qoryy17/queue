<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helpers\RouterLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\AuthRequest;

class AuthController extends Controller
{
    public function login(AuthRequest $request): RedirectResponse
    {
        // Validate the request
        $request->validated();

        $credentials = [
            'email' => htmlspecialchars($request->input('email')),
            'password' => htmlspecialchars($request->input('password')),
        ];

        // Check existing email, password, and block status
        $existingUser = User::where('email', $credentials['email'])->first();
        if (!$existingUser) {
            return redirect()->back()->with('error', 'Email not registered')->withInput();
        }

        if (!Hash::check($credentials['password'], $existingUser->password)) {
            return redirect()->back()->with('error', 'Wrong password !')->withInput();
        }

        if ($existingUser->block == 'Y') {
            return redirect()->back()->with('error', 'Yout account is blocked !')->withInput();
        }

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->with('error', 'Signin Failed, check your email and password !')->withInput();
        }

        Auth::login($existingUser, true);
        $request->session()->regenerate();
        $intended = RouterLink::intended(Auth::user()->role);
        return redirect()->intended($intended);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('signin');
    }
}
