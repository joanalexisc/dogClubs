<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    protected $createRules = [
        'names' => 'required|max:100',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|max:30',
        'personal_id' => 'required|digits:11',
        'mobile' => 'required|digits:10',
        'home' => 'digits:10',
        'birthday' => 'required|date',
        'last_names' => 'required|max:100',
        'sex' => 'required|max:1|in:M,F',
        'address' => 'required|max:500',
        'dogs' => 'required|array',
        'dogs.*.name' => 'required|max:150',
        'dogs.*.sex' => 'required|max:1|in:M,F',
        'dogs.*.birthday' => 'required|date',
        'dogs.*.purity' => 'required|digits:1',
        'dogs.*.breeder' => 'max:150',
        'dogs.*.mother' => 'max:150',
        'dogs.*.father' => 'max:150',
        'dogs.*.isAlive' => 'required|boolean'
    ];

    protected $updateRules = [
        'names' => 'required|max:100',
        'personal_id' => 'required|digits:11',
        'mobile' => 'required|digits:10',
        'home' => 'digits:10',
        'birthday' => 'required|date',
        'last_names' => 'required|max:100',
        'sex' => 'required|max:1|in:M,F',
        'address' => 'required|max:500',
        'dogs' => 'required|array',
        'dogs.*.id' => 'required|numeric',
        'dogs.*.name' => 'required|max:150',
        'dogs.*.sex' => 'required|max:1|in:M,F',
        'dogs.*.birthday' => 'required|date',
        'dogs.*.purity' => 'required|digits:1',
        'dogs.*.breeder' => 'max:150',
        'dogs.*.mother' => 'max:150',
        'dogs.*.father' => 'max:150',
        'dogs.*.isAlive' => 'required|boolean'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case "POST": return $this->createRules;
            case "PUT": return $this->updateRules;
            
        }
        return NULL;
    }
}
