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

}
