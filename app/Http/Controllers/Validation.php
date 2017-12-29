<?php 

namespace App\Repositories;

trait Validation
{
    public function validate() {
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            $error = $validator->messages()->toJson();
            return $error;//response()->json(['success'=> false, 'error'=> $error]);
        }
        return true;
    }

}