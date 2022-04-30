<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomAuthController extends Controller
{
    public function login(){
        return view ("auth.login");
    }

    public function registration(){
        return view ("auth.registration");
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'userID'=>'required|unique:users',
            'userName'=>'required',
            'userEmail' => 'required|email',
            'userPassword' => 'required|min:8|max:12',
            'privilige'=>'required'
        ]);
        $user = new User();
        $user->userID = $request->userID;
        $user->userName = $request->userName;
        $user->userEmail = $request->userEmail;
        $user->userPassword = $request->userPassword;
        $user->userPrivilige = $request->privilige;
        $user->country = "";
        $user->state = "";
        $user->district = "";
        $user->postcode = 0;
        $user->address = "";
        $res = $user->save();

        if($res){
            return back() ->with('success','You have registered successfully');
        }

        else{
            return back()->with('fail', 'Something Wrong');
        }
    }
}
