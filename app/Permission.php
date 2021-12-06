<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role','roles_permissions');
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class,'admins_permissions');
    }
}
