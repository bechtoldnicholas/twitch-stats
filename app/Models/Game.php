<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    
    protected $fillable = [  
        'name'
    ];

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }
}