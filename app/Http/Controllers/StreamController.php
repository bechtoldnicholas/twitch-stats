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
        if($request->order == 'asc')
        {
            $order = 'ASC';
        } else {
            $order = 'DESC';
        }

        $streams = Stream::orderBy('viewer_count', $order)->take(100)->get();

        return view('streams', compact('streams'));
    }

    public function getByStartDate(Request $request)
    {
        $streams = Stream::select('*')
                    ->get()
                    ->groupBy(function($stream) {
                        return date("Y-m-d H:00:00", strtotime($stream->start_date));
                    });
        return view('streams-by-date', compact('streams'));
    }

}
