<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Stream;
use App\Models\Game;
use DB;
class GameController extends Controller
{

    public function getTotalStreams(Request $request)
    {
        $games = Game::withCount('streams')->orderBy('streams_count', 'desc')->paginate(25);
        
        return view('streams-per-game', compact('games'));
    }

    public function getTopViewerCounts(Request $request)
    {
        // calculate in application layer
        $games = Game::all();

        foreach($games as $game)
        {

        }

        $games = DB::select(DB::raw(
            'SELECT
                g.*,
                s.*
            FROM
                games AS g
            LEFT JOIN
                streams AS s
            ON (g.id = s.game_id)
            WHERE s.viewer_count = (
                SELECT
                    MAX(viewer_count)
                FROM
                    streams AS s2
                WHERE
                    s2.game_id = g.id
            )
            ORDER BY s.viewer_count DESC'
        ));
        return view('viewers-per-game', compact('games'));
    }

}
