<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;
    
    public $incrementing = false;

    protected $fillable = [
        'channel_name',
        'stream_title',
        'viewer_count',
        'start_date',
    ];
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_stream');
    }
}
