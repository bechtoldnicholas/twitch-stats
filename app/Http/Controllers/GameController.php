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
        $games = Game::withCount('streams')->orderBy('streams_count', 'desc')->paginate(4);
        
        //return view('dashboard');
        return view('streams-per-game', compact('games'));
    }

}
