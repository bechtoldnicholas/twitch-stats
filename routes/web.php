<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Laravel\Socialite\Facades\Socialite;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard',function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/auth/redirect', function () {
    return Socialite::driver('twitch')->redirect();
})->name('auth-redirect');

Route::get('/auth/callback', [LoginController::class, 'handleCallback']);