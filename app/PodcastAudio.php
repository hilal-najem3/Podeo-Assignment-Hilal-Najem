<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PodcastAudio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'podcast_id', 'link'
    ];

    public function podcast() 
    {
        return $this->belongsTo(Podcast::class)->get()->first();
    }
}
