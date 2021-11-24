<?php

if(!function_exists('get_twitch_access_token'))
{
    function get_twitch_access_token()
    {
        $token_response = Illuminate\Support\Facades\Http::post('https://id.twitch.tv/oauth2/token', [
            'client_id' => env('TWITCH_CLIENT_ID'),
            'client_secret' => env('TWITCH_CLIENT_SECRET'),
            'grant_type' => 'client_credentials'
        ]);

        return $token_response->object()->access_token;
    }
}