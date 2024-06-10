<?php

namespace App;
use Illuminate\Validation\Rule;

trait RequestRules
{

    public function loginRules(){
        return [
            'username' => 'required|exists:App\Models\User,username',
            'password' => 'required',
        ];
    }

    public function loginRulesMessages(){
        return [
            'username.required' => 'username is required',
            'username.exists' => 'username does not exists',
            'password.required' => 'password is required',
        ];
    }

    public function registerRules(){
        return [
            'firstname' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ];
    }

    public function registerRulesMessages(){
        return [
            'firstname.required' => 'firstname is required',
            'firstname.max' => 'firstname must not exceed 255 characters',
            'username.required' => 'username is required',
            'username.max' => 'username must not exceed 255 characters',
            'username.unique' => 'username is already taken',
            'password.required' => 'password is required',
            'password.min' => 'password must be an 8 characters',
            'email.required' => 'email is required',
            'email.email' => 'invalid email format',
            'email.unique' => 'email is already taken',
        ];
    }

    public function voucherRules(){
        return [
            'user_id' => 'required'
        ];
    }

    public function voucherRulesMessages(){
        return [
            'user_id.required' => 'User ID is required'
        ];
    }
}
