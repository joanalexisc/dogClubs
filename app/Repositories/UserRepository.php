<?php 

namespace App\Repositories;
use App\User;
use App\Repositories\FilterableTrait;

class UserRepository  {

    use FilterableTrait;
    
    protected $validFilterableFields = ['email','personal_id','%names%','%last_names%','sex'];
    
    public function query(){
        return User::where("id",">","0");
    }
}