<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->getTags(get_twitch_access_token());
    }

    private function getTags($access_token, $cursor = null)
    {
        $tags_url = $cursor != null ? env('TWITCH_API_BASE').'/tags/streams?after='.$cursor : env('TWITCH_API_BASE').'/tags/streams';
        $tags_response = Http::withHeaders([
            'Authorization' => 'Bearer '.$access_token,
            'Client-ID' => env('TWITCH_CLIENT_ID')
        ])->get($tags_url);

        if(isset($tags_response->object()->data))
        {
            foreach($tags_response->object()->data as $twitch_tag)
            {
                $tag = Tag::firstOrNew([
                    'id' => $twitch_tag->tag_id,
                    'name' => $twitch_tag->localization_names->{"en-us"}
                ]);
                $tag->save();
            }
        } else {
            return true;
        }

        if(isset($tags_response->object()->pagination->cursor))
        {
            return $this->getTags($access_token, $tags_response->object()->pagination->cursor);
        }
    }
}
