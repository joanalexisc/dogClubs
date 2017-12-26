<?php

namespace App\utils;

use App\Http\Requests\UserRequest;
use Hash;

class CommonUtil
{
    public static function getValue($index,$values){
        return isset($values[$index]) ? $values[$index] : null;
    }

}