<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    public function users()
    {
        return $this->hasMany('App\User','club');
    }

    // public function breed(){
    //     return $this->belongsTo('App\Breed');
    // }
}
