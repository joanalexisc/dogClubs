<?php
namespace App\services;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

use App\Http\Requests\UserRequest;
use App\utils\EntityUtil;
use App\services\UserService;


class RoleService
{
    public function createRole(Request $request){
        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        return response()->json("created");       
    }

    public function createPermission(Request $request){
        $viewUsers = new Permission();
        $viewUsers->name = $request->input('name');
        $viewUsers->save();

        return response()->json("created");       
    }

    public function assignRole(Request $request){
        $user = User::where('email', '=', $request->input('email'))->first();

        $role = Role::where('name', '=', $request->input('role'))->first();
        //$user->attachRole($request->input('role'));
        $user->roles()->attach($role->id);

        return response()->json("created");
    }

    public function attachPermission(Request $request){
        $role = Role::where('name', '=', $request->input('role'))->first();
        $permission = Permission::where('name', '=', $request->input('name'))->first();
        $role->attachPermission($permission);

        return response()->json("created");       
    }
}