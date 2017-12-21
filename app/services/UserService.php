<?php

namespace App\services;

use App\Http\Requests\UserRequest;
use App\services\DogService;
use App\User;
use App\UserStatus;
use Hash;

class UserService
{
    protected $dogService;

    public function __construct(DogService $dogService)
    {
        $this->dogService = $dogService;
    }

    public function create(UserRequest $request)
    {
        $status_id = UserStatus::where('CODE', 'REG')->first()->id;

        $user = User::create([
            "names" => $request->names,
            "last_names" => $request->last_names,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "personal_id" => $request->personal_id,
            "mobile" => $request->mobile,
            "home" => $request->home,
            "birthday" => $request->birthday,
            "sex" => $request->sex,
            "address" => $request->address,
            "status" => $status_id,
        ]);
        $dogs = array();
        foreach ($request->dogs as $request_dog) {
            $dog = $this->dogService->create($request_dog);
            $user->dogs()->attach($dog);
            $dogs[] = $dog;
        }

        $user->dogs = $dogs;

        return $user;
    }

    public function getUsers(){
        return User::with("dogs")->get();
    }

    public function update(UserRequest $request,$id){
        $user = User::with("dogs")->find($id);
        $user->names = $request->names;
        $user->last_names = $request->last_names;
        // $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->personal_id = $request->personal_id;
        $user->mobile = $request->mobile;
        $user->home = $request->home;
        $user->birthday = $request->birthday;
        $user->sex = $request->sex;
        $user->address = $request->address;

        foreach ($request->dogs as $request_dog) {
            if($request_dog["id"] == 0){
                $dog = $this->dogService->create($request_dog);
                $user->dogs()->attach($dog);
            }else{
                
                foreach ($user->dogs as $model_dog){
                    if($model_dog->id == $request_dog["id"]){
                        $this->dogService->update($request_dog);
                        break;
                    }
                }
            }
        }

        $user->save();
    }

}
