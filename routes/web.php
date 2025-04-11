<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\NonAuthMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\HomeScreenController;
use App\Http\Controllers\Auth\SigninController;
use App\Http\Controllers\Queue\QueueController;
use App\Http\Controllers\Configure\LogController;
use App\Http\Controllers\Queue\QueueLogController;
use App\Http\Controllers\Configure\VoiceController;
use App\Http\Controllers\Counter\CounterController;
use App\Http\Controllers\Officer\OfficerController;
use App\Http\Controllers\Configure\SettingController;

Route::get('/', function () {
    return redirect()->route('signin');
});

// Signin Routing
Route::middleware(NonAuthMiddleware::class)->group(function () {
    Route::controller(SigninController::class)->group(function () {
        Route::get('signin', 'index')->name('signin');
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
});

Route::middleware(AuthMiddleware::class)->group(function () {
    // Home Routing
    Route::controller(HomeController::class)->group(function () {
        Route::get('home/administrator', 'indexAdmin')->name('home.admin');
        Route::get('home/officer', 'indexOfficer')->name('home.officer');
    });

    // Queue Logs Controller Routing
    Route::controller(QueueLogController::class)->group(function () {
        Route::get('queue-logs', 'index')->name('queue-logs.index');
        Route::delete('queue-logs/delete', 'destroy')->name('queue-logs.delete');
    });

    // Queue Routing
    Route::controller(QueueController::class)->group(function () {
        Route::get('queues', 'index')->name('queues.index');
    });

    // Users Routing
    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('users.index');
        Route::get('users/form/{param}', 'form')->name('users.form');
        Route::post('users/store', 'store')->name('users.store');
        Route::delete('users/delete', 'destroy')->name('users.delete');
    });

    // Officers Routing
    Route::controller(OfficerController::class)->group(function () {
        Route::get('officers', 'index')->name('officers.index');
        Route::get('officers/form/{param}', 'form')->name('officers.form');
        Route::post('officers/store', 'store')->name('officers.store');
        Route::delete('officers/delete', 'destroy')->name('officers.delete');
        Route::get('officers/show/{id}', 'show')->name('officers.show');
    });

    // Counters Routing
    Route::controller(CounterController::class)->group(function () {
        Route::get('counters', 'index')->name('counters.index');
        Route::get('counters/form/{param}', 'form')->name('counters.form');
        Route::post('counters/store', 'store')->name('counters.store');
        Route::delete('counters/delete', 'destroy')->name('counters.delete');
    });

    // Configure Routing
    Route::controller(VoiceController::class)->group(function () {
        Route::get('voice', 'index')->name('voice.index');
        Route::post('voice/store', 'store')->name('voice.store');
    });

    Route::controller(SettingController::class)->group(function () {
        Route::get('setting', 'index')->name('setting.index');
        Route::post('setting/store', 'store')->name('setting.store');
    });

    Route::controller(LogController::class)->group(function () {
        Route::get('logs', 'index')->name('logs.index');
        Route::delete('logs/delete', 'destroy')->name('logs.delete');
    });
});


// Home Screeen Routing
Route::controller(HomeScreenController::class)->group(function () {
    Route::get('home-screen', 'index')->name('homeScreen.index');
});
