<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RouterLink
{
    public static function intended($role = null)
    {
        if ($role == \App\Enum\RolesEnum::ADMIN->value) {
            return 'home/administrator';
        } elseif ($role == \App\Enum\RolesEnum::OFFICER->value) {
            return 'home/officer';
        } else {
            Auth::logout();
            session()->invalidate();
            session()->regenerate();
            return redirect()->route('signin')->with('error', 'You are not authorized to access this page');
        }
    }

    public static function redirect($role = null)
    {
        if ($role == \App\Enum\RolesEnum::ADMIN->value) {
            return redirect()->route('home.admin');
        } elseif ($role == \App\Enum\RolesEnum::OFFICER->value) {
            return redirect()->route('home.officer');
        } else {
            Auth::logout();
            session()->invalidate();
            session()->regenerate();
            return redirect()->route('signin')->with('error', 'You are not authorized to access this page');
        }
    }
    public static function route($role = null)
    {
        if ($role == \App\Enum\RolesEnum::ADMIN->value) {
            return route('home.admin');
        } elseif ($role == \App\Enum\RolesEnum::OFFICER->value) {
            return route('home.officer');
        } else {
            Auth::logout();
            session()->invalidate();
            session()->regenerate();
            return redirect()->route('signin')->with('error', 'You are not authorized to access this page');
        }
    }

    public static function string($role = null)
    {
        if ($role == \App\Enum\RolesEnum::ADMIN->value) {
            return 'home.admin';
        } elseif ($role == \App\Enum\RolesEnum::OFFICER->value) {
            return 'home.officer';
        } else {
            Auth::logout();
            session()->invalidate();
            session()->regenerate();
            return redirect()->route('signin')->with('error', 'You are not authorized to access this page');
        }
    }

    public static function queue($role = null)
    {
        if ($role == \App\Enum\RolesEnum::ADMIN->value) {
            return 'queue-logs.index';
        } elseif ($role == \App\Enum\RolesEnum::OFFICER->value) {
            return 'queues.index';
        } else {
            Auth::logout();
            session()->invalidate();
            session()->regenerate();
            return redirect()->route('signin')->with('error', 'You are not authorized to access this page');
        }
    }

}
