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
                $userID = $user->id;
                $request->session() -> put('userId', $userID);
                $request->session() -> put('userPrivilige',$user->userPrivilige);
                
                //Update Number of items
                $userID = $user->id;
                $itemAmount = CartItem::where('userID',$userID) -> sum('qty');
                $request->session() -> put('numItem',$itemAmount);
                
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
                $request->session() -> put('priceItem',$sumTotal);
                
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

    
}
