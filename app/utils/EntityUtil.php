<?php

namespace App\utils;

use App\Http\Requests\UserRequest;
use Hash;

class EntityUtil
{
    public static function getUserModel(UserRequest $request){
        $user = new \App\User;
        //'names', 'email', 'password','is_verified','personal_id','mobile','home','birthday','last_names','sex','address','club'
        $user->names = $request->names;
        $user->last_names = $request->last_names;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->personal_id = $request->personal_id;
        $user->mobile = $request->mobile;
        $user->home = $request->home;
        $user->birthday = $request->birthday;
        $user->sex = $request->sex;
        $user->address = $request->address;
        // $user->role = \App\Role::where('CODE','USR')->first();
        $user->status = 1;//register pending for aprovation
        
        return $user;
    }

    public static function getDogModels(UserRequest $request){
        $dogs = array();
        foreach($request->dogs as $rd){
            $dog = new \App\Dog;
            $dog->name = $rd["name"];
            $dog->sex  = $rd["sex"];
            $dog->birthday  = $rd["birthday"];
            $dog->purity  = $rd["purity"];
            $dog->breeder  = $rd["breeder"];
            $dog->mother  = $rd["mother"];
            $dog->father  = $rd["father"];
            $dog->isAlive  = $rd["isAlive"];
            $dogs[] = $dog;
        }
        return $dogs;
    }

}