<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Stream;
class StreamController extends Controller
{

    public function get(Request $request)
    {
        $streams = Stream::where('viewer_count', '>', 10000)->get();
        dd($streams[0]->game);
    }

}
