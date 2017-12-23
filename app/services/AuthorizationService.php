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


class AuthorizationService
{ 
    public function generateVerificationCode($user_id)
    {
        $verification_code = str_random(30); 
        DB::table('user_verifications')->insert(['user_id'=>$user_id,'token'=>$verification_code]);
    }

    public function verifyUser($verification_code)
    {
        $check = DB::table('user_verifications')->where('token',$verification_code)->first();
        if(!is_null($check)){
            $user = User::find($check->user_id);
            if($user->is_verified == 1){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Account already verified..'
                ]);
            }
            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token',$verification_code)->delete();
            return response()->json([
                'success'=> true,
                'message'=> 'You have successfully verified your email address.'
            ]);
        }
        return response()->json(['success'=> false, 'error'=> "Verification code is invalid."]);
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $input = $request->only('email', 'password');
        $validator = Validator::make($input, $rules);

        $user_status = \App\UserStatus::where('CODE','APPR')->first()->id; 

        if($validator->fails()) {
            $error = $validator->messages()->toJson();
            return response()->json(['success'=> false, 'error'=> $error]);
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'is_verified' => 1,
            'status' => $user_status
        ];
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Invalid Credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => "Bearer " . $token ]]);
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