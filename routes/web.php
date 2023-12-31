<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Verify;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\TaskComponent;
use App\Http\Livewire\TodoComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\EmailVerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('change-locale/{locale}', LocaleController::class)->name('change.locale');

Route::middleware('locale')->group(function () {

    Route::view('/', 'welcome')->name('home');

    Route::middleware('guest')->group(function () {
        Route::get('login', Login::class)
            ->name('login');

        Route::get('register', Register::class)
            ->name('register');
    });

    Route::get('password/reset', Email::class)
        ->name('password.request');

    Route::get('password/reset/{token}', Reset::class)
        ->name('password.reset');

    Route::middleware('auth')->group(function () {
        Route::get('email/verify', Verify::class)
            ->middleware('throttle:6,1')
            ->name('verification.notice');

        Route::get('password/confirm', Confirm::class)
            ->name('password.confirm');
    });

    Route::middleware('auth')->group(function () {
        Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
            ->middleware('signed')
            ->name('verification.verify');

        Route::get('logout', LogoutController::class)
            ->name('logout');
    });
    Route::get('/todos', TodoComponent::class)->name('todos');
    Route::get('/todos/{todo}/tasks', TaskComponent::class)->name('todo.tasks');
});
