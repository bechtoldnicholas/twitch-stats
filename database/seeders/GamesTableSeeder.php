<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->getGames(get_twitch_access_token());
    }

    private function getGames($access_token, $cursor = null)
    {
        $games_url = $cursor != null ? env('TWITCH_API_BASE').'/games/top?after='.$cursor : env('TWITCH_API_BASE').'/games/top';
        $games_response = Http::withHeaders([
            'Authorization' => 'Bearer '.$access_token,
            'Client-ID' => env('TWITCH_CLIENT_ID')
        ])->get($games_url);
        
        if(isset($games_response->object()->data))
        {
            foreach($games_response->object()->data as $twitch_game)
            {
                $game = Game::firstOrNew([
                    'id' => $twitch_game->id,
                    'name' => $twitch_game->name
                ]);

                $game->save();
            }
        } else {
            return true;
        }

        if(isset($games_response->object()->pagination->cursor) && Game::count() < 1000)
        {
            return $this->getGames($access_token, $games_response->object()->pagination->cursor);
        }
    }
}
