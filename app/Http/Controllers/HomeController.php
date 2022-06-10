<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Stock;
use Session;
use DB;

class HomeController extends Controller
{
    
    public function processCart(Request $request)
    {
        if(Session::has('userId')){
            //Get Value
            $userID = Session::get('userId');
            $ISBN13 = $request->bookISBN;
            $stock = Stock::find($ISBN13);

            //Sum value
            $newPrice = $this-> calculateNewPrice($stock->retailPrice);
            $newItemCount = $this-> calculateNewQuantity();

            //Update session
            $sessionUpdated = $this -> updateSession($newPrice,$newItemCount,$request);
            
            //Check Session updated
            if($sessionUpdated){
                //check if the book exists for the user already
                $check = $this -> checkExist($userID,$ISBN13);
                if($check){
                    $this -> updateDB($userID,$ISBN13);
                }
                //Upload to database
                else{
                    $this -> uploadDB($userID,$ISBN13);
                }
            }
            
            else{
                return redirect()->route('addCart');
            }

            // put cart data in array to be returned
            $data = $this -> isLoggedIn ($newItemCount,$newPrice,True);
        }

        else{
            $data = $this -> isLoggedIn (0,0,False);  
        }

        $data = json_encode($data);
        return $data;
    }

    //------------------------------------------------------------LOGGED IN------------------------------------------------------------
    public function isLoggedIn($newItemCount,$newPrice,$loggedIn){
        $data = array('qty' => $newItemCount, 'price' => $newPrice, 'login' => $loggedIn);
        return $data;
    }

    //------------------------------------------------------------CALCULATION------------------------------------------------------------
    public function calculateNewPrice($itemPrice){
        $initialPrice = Session::get('priceItem');
        $newPrice = $initialPrice+$itemPrice;
        return $newPrice;
    }

    public function calculateNewQuantity(){
        $initialItemCount = Session::get('numItem');
        $newQuantity=$initialItemCount+1;
        return $newQuantity;
    }

    //----------------------------------------------------------UPDATE SESSION------------------------------------------------------------
    public function updateSession($newPrice,$newQty){
        Session:: put('numItem',$newQty);
        Session:: put('priceItem',$newPrice);
        return true;
    }

    //-----------------------------------------------------CHECK BOOK EXIST FOR USER-------------------------------------------------------
    public function checkExist($userID,$ISBN13){
        if(CartItem::where('userID',$userID)->where('ISBN13',$ISBN13)->exists()){
            return true;
        }
        else{
            return false;
        }
    }

    //-----------------------------------------------------UPDATE DATABASE-------------------------------------------------------
    public function updateDB($userID,$ISBN13){
        $existingValue = CartItem::select('qty')->where('userID',$userID) ->Where('ISBN13',$ISBN13) ->get();
        $existingValue = preg_replace('/[^0-9]/','',$existingValue);
        $updatedNumValue =$existingValue+1;
        CartItem::where('userID',$userID) ->Where('ISBN13',$ISBN13) -> update(['qty' => $updatedNumValue]);
    }

    //-----------------------------------------------------UPLOAD DATABASE-------------------------------------------------------
    public function uploadDB($userID,$ISBN13){
        $cartItem = new CartItem();
        $cartItem->userID = $userID;
        $cartItem->ISBN13 = $ISBN13;
        $cartItem->qty = 1;
        $res = $cartItem->save();
    }

    //-----------------------------------------------------OTHER PAGES-------------------------------------------------------
    public function shoppingCartView(Request $request){
        if(Session::has('userId')){
            return view("shoppingCart");
        }else{
            return redirect()->route('LoginUser');
        }
    }

    public function getUserAddress(Request $request){
        if(Session::has('userId')){
            $userID = Session::get('userId');
            $user = User::find($userID);
            return $user;
        }
        
        return null;
    }
}

