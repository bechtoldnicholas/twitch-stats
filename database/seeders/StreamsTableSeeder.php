<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Stream;
class StreamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Db::table('streams')->truncate();
        $this->getStreams(get_twitch_access_token());
    }

    private function getStreams($access_token, $cursor = null)
    {
        $streams_url = $cursor != null ? env('TWITCH_API_BASE').'/streams?after='.$cursor : env('TWITCH_API_BASE').'/streams';
        $streams_response = Http::withHeaders([
            'Authorization' => 'Bearer '.$access_token,
            'Client-ID' => env('TWITCH_CLIENT_ID')
        ])->get($streams_url);
        
        if(isset($streams_response->object()->data))
        {
            foreach($streams_response->object()->data as $twitch_stream)
            {

                $stream = Stream::firstOrNew([
                    'id' => $twitch_stream->id,
                ]);
                $stream->channel_name = $twitch_stream->user_name;
                $stream->stream_title = $twitch_stream->title;
                $stream->viewer_count = $twitch_stream->viewer_count;
                $stream->start_date = date("Y-m-d H:i:s",strtotime($twitch_stream->started_at));
                $stream->game_id = $twitch_stream->game_id != "" ? $twitch_stream->game_id : null;
                $stream->save();

                foreach($twitch_stream->tag_ids as $tag_id)
                {
                    $stream->tags()->attach($tag_id);
                }
            }
        } else {
            return true;
        }

        if(isset($streams_response->object()->pagination->cursor) && Stream::count() < 1000)
        {
            return $this->getStreams($access_token, $streams_response->object()->pagination->cursor);
        }
    }
}
