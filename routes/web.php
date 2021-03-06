<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;

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


Route::get('/auth/redirect', function () {
    return Socialite::driver('twitch')->scopes(['user:read:follows'])->redirect();
})->name('auth-redirect');

Route::get('/auth/callback', [LoginController::class, 'handleCallback']);


Route::middleware(['web'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::get('/streams',[StreamController::class, 'get'])->name('streams');
    Route::get('/streams/start-date',[StreamController::class, 'getByStartDate'])->name('streams-start-date');

    Route::get('/games/total-streams',[GameController::class, 'getTotalStreams'])->name('games-total-streams');
    Route::get('/games/top-viewer-count',[GameController::class, 'getTopViewerCounts'])->name('games-top-viewer-count');
});
