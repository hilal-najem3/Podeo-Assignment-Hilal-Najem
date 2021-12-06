<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    public function permissions() 
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class,'admins_roles');
    }
}
