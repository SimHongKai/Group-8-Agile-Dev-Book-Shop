<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;

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
            'userName'=>'required|regex:/^[a-zA-Z]+$/u',
            'userEmail' => 'required|email',
            'userPassword' => 'required|min:8|max:12|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!_%*#?&]/',
            'privilige'=>'required|gt:0|lt:3'
        ]);
        $user = new User();
        $user->userID = $request->userID;
        $user->userName = $request->userName;
        $user->userEmail = $request->userEmail;
        $user->userPassword = Hash::make($request->userPassword);
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

    public function loginUser(Request $request)
    {
        $request->validate([
            'userID'=>'required',
            'userPassword' => 'required|min:8|max:12',
        ]);
        $user = User::where('userID','=',$request->userID)->first();
        if($user){
            if(Hash::check($request->userPassword, $user->userPassword)){
                $request->session() -> put('loginId',$user->userID);
                return redirect('dashboard');
            }
            else{
                return back()->with('fail','Password Incorrect');
            }
        }
        else{
            return back()->with('fail','This User ID is not registered');
        }
    }

    public function dashboard(){
        $data = array ();
        if (Session::has('loginId')){
            $data = User::where('userID', '=', Session::get('loginId'))->first();
        }
        return view ('dashboard', compact('data'));
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
