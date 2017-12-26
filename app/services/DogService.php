<?php

namespace App\services;

use App\Dog;
use App\utils\CommonUtil;

class DogService
{
    public function create($request_dog)
    {

        $dog = Dog::create([
            "name" => $request_dog["name"],
            "sex" => $request_dog["sex"],
            "birthday" => $request_dog["birthday"],
            "purity" => $request_dog["purity"],
            "chip_number" => CommonUtil::getValue("chip_number", $request_dog),
            "breeder" => CommonUtil::getValue("breeder", $request_dog),
            "mother" => CommonUtil::getValue("mother", $request_dog),
            "father" => CommonUtil::getValue("father", $request_dog),
            "isAlive" => $request_dog["isAlive"],
        ]);

        return $dog;
    }

    public function update($request_dog)
    {
        $dog = Dog::find($request_dog["id"]);
        $dog->name = $request_dog["name"];
        $dog->sex = $request_dog["sex"];
        $dog->birthday = $request_dog["birthday"];
        $dog->purity = $request_dog["purity"];
        $dog->chip_number = CommonUtil::getValue("chip_number", $request_dog);
        $dog->breeder = CommonUtil::getValue("breeder", $request_dog);
        $dog->mother = CommonUtil::getValue("mother", $request_dog);
        $dog->father = CommonUtil::getValue("father", $request_dog);
        $dog->isAlive = $request_dog["isAlive"];
        
        

        $dog->save();
        
        return $dog;
    }

    public function delete($id){
        $dog = Dog::with("users")->find($id);
        foreach($dog->users as $user){
            $dog->users()->detach($user->id); 
        }
        Dog::destroy($id);
    }

    public function removeUser($id, $user){
        // $count = $post->comments()->count()
        $dog = Dog::find($id);
        $count = $dog->users()->count();
        $dog->users()->detach($user);
        if($count == 1){
            Dog::destroy($id);
        }
    }
}
