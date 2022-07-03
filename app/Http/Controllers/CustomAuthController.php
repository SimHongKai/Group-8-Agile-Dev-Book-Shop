<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Stock;
use Hash;
use Session;
use DB;

class CustomAuthController extends Controller
{
    //Function to sign up user
    public function registerUser(Request $request)
    {
        //validate before storing to database
        $this->signUpValidate($request);
        
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
        $res = $this->signUpFunction($user);
        
        if($res){
            return redirect('home')->with('success','You have registered successfully');
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
        $email = $request->userEmail;
        $user = User::where('userEmail','=',$email)->first();
        
        $dbpassword = $user->userPassword;
        $typepassword = $request->userPassword;
        $userStatus = $this -> signInUserFoundFunction($email);

        if($userStatus){
            $passwordStatus = $this -> signInPassValidateFunction($typepassword, $dbpassword);
            if($passwordStatus){
                $userID = $user->id;
                $userPriv = $user->userPrivilige;
                $itemAmount = CartItem::where('userID',$userID) -> sum('qty');

                //Update Price
                $sumTotal = DB::table('shopping_cart')
                ->join('stock','shopping_cart.ISBN13',"=",'stock.ISBN13')
                ->where('userID',$userID)
                ->selectRaw('SUM(stock.retailPrice * shopping_cart.qty) as total')
                ->get();

                $sumTotal = preg_replace('/[^0-9.]/','',$sumTotal);
                if($sumTotal==null){
                    $sumTotal = 0;
                }

                $this -> updateSessionSignIn($userID,$userPriv,$itemAmount,$sumTotal);
                
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

    public function signUpValidate(Request $request){
        $request->validate([
            'userName'=>'required|min:0|max:255|',
            'userEmail' => 'required|email|unique:users|min:0|max:255|',
            'userPassword' => 'required|min:8|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!_%*#?&]/',
            'privilige'=>'required|regex:/[0-9]/|gt:0|lt:3'
        ]);
    }

    public function signUpFunction($user){
        $res = $user->save();
        if($res){
            return TRUE;
        }
    }

    public function signInUserFoundFunction($email){
        $user = User::where('userEmail','=',$email)->first();

        if($user){
            return $user;
        }
        else{
            return FALSE;
        }
    }

    public function signInPassValidateFunction($typepassword, $dbpassword){
        if(Hash::check($typepassword, $dbpassword)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    //Function after press home button
    public function home(){
        $stocks = DB::select('select * from stock');
        return view('home')->with(compact('stocks'));
    }

    //Function after press log out button
    public function logout(){
        if(Session::has('userId')){
            Session::pull('userId');
            Session::pull('userPrivilige');
            return redirect('login');
        }
    }

    public function updateSessionSignIn($userID,$userPriv,$itemAmount,$sumTotal){
        Session::put('userId',$userID);
        Session::put('userPrivilige',$userPriv);
        Session::put('numItem',$itemAmount);
        Session::put('priceItem',$sumTotal);
    }

    //Function to go sign in page
    public function login(){
        return view ("auth.login");
    }

    //Function to go sign up page
    public function registration(){
        return view ("auth.registration");
    }

}
