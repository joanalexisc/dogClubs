<?php
namespace App\Http\Controllers;
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
use App\services\RoleService;
use App\services\AuthorizationService;


class AuthController extends Controller
{   
    protected $roleService, $authService;

    public function __construct(RoleService $roleService, AuthorizationService $authService){
        $this->roleService = $roleService;
        $this->authService = $authService;
    }

    public function verifyUser($verification_code)
    {
        return $this->authService->verifyUser($verification_code);
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function token(){
        return $this->authService->token();
    }

    public function logout(Request $request) {
        return $this->authService->logout($request);
    }

    public function recover(Request $request)
    {   
        return $this->authService->recover($request);
    }

    public function createRole(Request $request){
        return $this->$roleService->createRole($request);
    }

    public function createPermission(Request $request){
        return $this->$roleService->createPermission($request);
    }

    public function assignRole(Request $request){
        return $this->$roleService->assignRole($request);
    }

    public function attachPermission(Request $request){
        return $this->$roleService->attachPermission($request);
    }
}