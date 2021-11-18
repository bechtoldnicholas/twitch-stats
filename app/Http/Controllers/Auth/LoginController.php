<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function handleCallback(Request $request)
    {
        $socialUser = Socialite::driver('twitch')->user();
        
        $user = User::whereTwitchId($socialUser->id)->whereEmail($socialUser->email)->first();

        if(empty($user))
        {
            $user = User::create([
                'username' => $socialUser->name,
                'email' => $socialUser->email,
                'twitch_id' => $socialUser->id
            ]);
        }

        Auth::login($user);

        return redirect()->to('dashboard');
        dd($user->token);
        $response = Http::withHeaders(['Client-Id' => env('TWITCH_CLIENT_ID')])->withToken($user->token)->get('https://api.twitch.tv/helix/streams');

        dd($response->body());
    }
}
