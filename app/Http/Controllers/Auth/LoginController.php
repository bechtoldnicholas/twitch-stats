<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Stream;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function handleCallback(Request $request)
    {
        $socialUser = Socialite::driver('twitch')->user();
        
        // get user by twitch id or create if doesn't exist
        $user = User::whereTwitchId($socialUser->id)->whereEmail($socialUser->email)->first();

        if(empty($user))
        {
            $user = User::create([
                'username' => $socialUser->name,
                'email' => $socialUser->email,
                'twitch_id' => $socialUser->id,
                'token' => $socialUser->token
            ]);
        } else {
            $user->token = $socialUser->token;
            $user->save();
        }

        Auth::login($user);


        return redirect()->to('dashboard');
    }
}
