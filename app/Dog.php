<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    protected $fillable = [
        "name",
        "sex",
        "birthday",
        "purity",
        "breeder",
        "mother",
        "father",
        "isAlive",
    ];
    //
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
