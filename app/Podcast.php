<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'link', 'admin_id'
    ];

    public function admin() 
    {
        return $this->belongsTo(Admin::class)->get()->first();
    }
}
