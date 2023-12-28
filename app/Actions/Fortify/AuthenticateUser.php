<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser {

    public function authenticate($request) {

        
            $username = $request->post(config('fortify.username'));
            $password = $request->post('password');
            $user = Admin::where('username' , '=', $username)
            ->orWhere('email','=', $username)
            ->orWhere('phone_number', '=', $username)
            //->where('password', '=', $password)
            ->first();
            if($user && Hash::check($password, $user->password)) {
                //Auth::guard('admin')->login($user);
                return $user;
            }
            return false;
        
    }
}
