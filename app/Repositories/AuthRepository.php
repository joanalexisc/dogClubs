<?php

namespace App\Repositories;

use DB, Hash, Mail;

class AuthRepository{
    public function findVerification($verification_code){
        return DB::table('user_verifications')->where('token',$verification_code)->first();
    }

    public function verifyUser($user){
        $user->update(['is_verified' => 1]);
        DB::table('user_verifications')->where('token',$verification_code)->delete();
    }
}