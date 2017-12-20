<?php

namespace App\services;

use App\Dog;

class DogService
{
    public function create($request_dog)
    {

        $dog = Dog::create([
            "name" => $request_dog["name"],
            "sex" => $request_dog["sex"],
            "birthday" => $request_dog["birthday"],
            "purity" => $request_dog["purity"],
            "breeder" => $request_dog["breeder"],
            "mother" => $request_dog["mother"],
            "father" => $request_dog["father"],
            "isAlive" => $request_dog["isAlive"],
        ]);

        return $dog;
    }
}
