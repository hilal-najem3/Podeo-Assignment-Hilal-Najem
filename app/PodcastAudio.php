<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\UploadOrGetFileHelper;

class PodcastAudio extends Model
{
    protected $table = 'podcast_audios';
    
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

    public function myLink() 
    {
        return UploadOrGetFileHelper::getFile($this->link);
    }
}
