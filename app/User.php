<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'names', 'email', 'password','is_verified','personal_id','mobile','home','birthday','last_names','sex','address','club'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function club(){
       return $this->belongsTo('App\Club','club');
    }

    public function dogs(){
        return $this->belongsToMany('App\Dog');
    }
}
