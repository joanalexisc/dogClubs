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
use App\services\OperationReponse;
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
        $result = $this->authService->verifyUser($verification_code);
        $response = null;
        switch ($result) {
            case OperationReponse::NOT_FOUND:
                $response = ['success'=> false, 'error'=> "Verification code is invalid."];
                break;
            case OperationReponse::VALIDATED:
                $response = ['success'=> true, 'message'=> 'Account already verified..'];
                break;
            case OperationReponse::SUCCESS:
                $response = ['success'=> true, 'message'=> 'You have successfully verified your email address.'];
                break;
        }
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $input = $request->only('email', 'password');

        $toke = $this->authService->login($input); 
        
        $response = null;

        if($toke === OperationReponse::ERROR){
            $response = response()->json(['success' => false, 'error' => 'could_not_create_token'], 500);
        }else if($toke === OperationReponse::INVALID_CREDENTIALS){
            $response = response()->json(['success' => false, 'error' => 'Invalid Credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
        }else{
            $response = response()->json(['success' => true, 'data'=> [ 'token' => "Bearer " . $token ]]);
        }

        return $response;
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