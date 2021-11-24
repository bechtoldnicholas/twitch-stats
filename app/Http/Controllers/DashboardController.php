<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Stream;
use App\Models\Tag;
use DB;
use Carbon\Carbon;
class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $streams = Stream::all();
        $median_viewer_count = $streams->median('viewer_count');

        $access_token = get_twitch_access_token();

        $followed_streams_response = Http::withHeaders([
            'Authorization' => 'Bearer '. \Auth::user()->token,
            'Client-ID' => env('TWITCH_CLIENT_ID')
        ])->get('https://api.twitch.tv/helix/streams/followed?user_id='.\Auth::user()->twitch_id);

        // get number of streams in top 1000 current user follows
        // get lowest viewed followed stream
        $followed_stream_ids = [];
        $lowest_viewed_followed_stream_followers = isset($followed_streams_response->object()->data[0]) ? $followed_streams_response->object()->data[0]->viewer_count : 0;
        $followed_stream_tags = DB::table('tag_stream')
                                    ->select('tag_id')
                                    ->groupBy('tag_id')
                                    ->get();
        $followed_stream_tags = $followed_stream_tags->pluck('tag_id')->toArray();
        $shared_tags = [];

        foreach($followed_streams_response->object()->data as $followed_stream)
        {
            foreach($followed_stream->tag_ids as $tag)
            {
                // get shared tags from followed streams
                if(in_array($tag, $followed_stream_tags) && !array_key_exists($tag, $shared_tags))
                {
                    $shared_tags[$tag] = Tag::find($tag)->name;
                }
            }
            // get lowest followed stream viewer count
            if($followed_stream->viewer_count < $lowest_viewed_followed_stream_followers)
            {
                $lowest_viewed_followed_stream_followers = $followed_stream->viewer_count;
            }
            // get followed stream ids for followed streams in top 1000
            $followed_stream_ids[] = $followed_stream->id;
            $lowest_viewed_followed_stream = $followed_stream;
        }
        
        $followed_streams = Stream::whereIn('id', $followed_stream_ids)->pluck('channel_name')->toArray();
        $views_required = Stream::whereNotNull('viewer_count')->min('viewer_count') - $lowest_viewed_followed_stream->viewer_count;

        return view('dashboard', compact('median_viewer_count', 'followed_streams', 'lowest_viewed_followed_stream', 'views_required', 'shared_tags'));
    }

}
