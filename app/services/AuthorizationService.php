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
use App\services\OperationReponse;
use App\Repositories\AuthRepository;


class AuthorizationService
{ 
    protected $userService;
    protected $authRepository;

    public function __construct(AuthRepository $authRepository, UserService $userService){
        $this->authRepository = $authRepository;
        $this->userService = $userService;
    }

    public function generateVerificationCode($user_id)
    {
        $verification_code = str_random(30); 
        DB::table('user_verifications')->insert(['user_id'=>$user_id,'token'=>$verification_code]);
        return $verification_code;
    }

    public function verifyUser($verification_code)
    {
        $result = OperationReponse::NOT_FOUND;
        $check = $this->authRepository->findVerification($verification_code);
        if(!is_null($check)){
            $user = $this->userService->find($check->user_id);
            if($user->is_verified == 1){
                $result = OperationReponse::VALIDATED;
            }else{
                $this->authRepository->verifyUser($user);
                $result = OperationReponse::SUCCESS;
            }
        }
        return $result;
    }

    public function login($credentials)
    {

         $user_status = \App\UserStatus::where('CODE','APPR')->first()->id; 
         $credentials['is_verified'] = 1;
         $credentials['status'] = $user_status;

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return OperationReponse::INVALID_CREDENTIALS;
            }
        } catch (JWTException $e) {
            return OperationReponse::ERROR; 
        }
        return $token;
    }

    public function token(){
        $token = JWTAuth::getToken();
        if(!$token){
            throw new BadRequestHtttpException('Token not provided');
        }
        try{
            $token = JWTAuth::refresh($token);
        }catch(TokenInvalidException $e){
            throw new AccessDeniedHttpException('The token is invalid');
        }
        return response()->json(['token'=>$token]);
    }

    public function logout(Request $request) {
        $token = $token = JWTAuth::getToken();
        try {
            JWTAuth::invalidate($token);
            return response()->json(['success' => true]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Your Password Reset Link');
            });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'data'=> ['msg'=> 'A reset email has been sent! Please check your email.']
        ]);
    }

}