<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stock;
use Hash;
use Session;
use DB;

class CustomAuthController extends Controller
{
    

    //Function to go sign in page
    public function login(){
        return view ("auth.login");
    }

    //Function to go sign up page
    public function registration(){
        return view ("auth.registration");
    }

    //Function to sign up user
    public function registerUser(Request $request)
    {
        //validate before storing to database
        $request->validate([
            'userName'=>'required|min:0|max:255|',
            'userEmail' => 'required|email|unique:users|min:0|max:255|',
            'userPassword' => 'required|min:8|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!_%*#?&]/',
            'privilige'=>'required|regex:/[0-9]/|gt:0|lt:3'
        ]);
        //Create new object and store to database
        $user = new User();
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

    //Function after press log in button
    public function loginUser(Request $request)
    {
        //validate before compare to database
        $request->validate([
            'userEmail'=>'required|email|min:0|max:255|',
            'userPassword' => 'required|min:8|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!_%*#?&]/',
        ]);
        //Compare to database
        $user = User::where('userEmail','=',$request->userEmail)->first();
        if($user){
            if(Hash::check($request->userPassword, $user->userPassword)){
                $request->session() -> put('loginEmail',$user->userEmail);
                return redirect('home');
            }
            else{
                return back()->with('fail','Password Incorrect');
            }
        }
        else{
            return back()->with('fail','This User Email is not registered');
        }
    }

    //Function after press home button
    public function home(){
        $data = array ();

        if (Session::has('loginEmail')){
            $data = User::where('userEmail', '=', Session::get('loginEmail'))->first(); 
        }

        $stocks = DB::table('stock')
                        ->where('qty','>',0)
                        ->get();
        return view('home')->with(compact('data'))->with(compact('stocks'));
    }

    public function new_page($view){
        $data = array ();
        
        if (Session::has('loginEmail')){
            $data = User::where('userEmail', '=', Session::get('loginEmail'))->first(); 
        }
        return view ($view, compact('data'));
    }

    //Function after press log out button
    public function logout(){
        if(Session::has('loginEmail')){
            Session::pull('loginEmail');
            return redirect('login');
        }
    }

    
}
