<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\User;
use Session;
use DB;

class HomeController extends Controller
{
    public function processCart(Request $request)
    {
        if(Session::has('userId')){   
            //Get value
            $userID = Session::get('userId');
            $selectedPrice = $request->addButton;
            $ISBNValue=$request->bookISBN;

            //Sum value
            $newPrice = $this-> calculateNewPrice($selectedPrice);
            $newItemCount = $this-> calculateNewQuantity();
            //Update session
            $sessionUpdated = $this -> updateSession($newPrice,$newItemCount,$request);

            if($sessionUpdated){
                //Upload to database 
                //check if the book exists for the user already
                if(CartItem::where('userID',$userID)->where('ISBN13',$ISBNValue)->exists()){
                    $existingValue = CartItem::select('qty')->where('userID',$userID) ->Where('ISBN13',$ISBNValue) ->get();
                    $existingValue = preg_replace('/[^0-9]/','',$existingValue);
                    $updatedNumValue =$existingValue+1;
                    CartItem::where('userID',$userID) ->Where('ISBN13',$ISBNValue) -> update(['qty' => $updatedNumValue]);
                }
                else{
                    $cartItem = new CartItem();
                    $cartItem->userID = $userID;
                    $cartItem->ISBN13 = $ISBNValue;
                    $cartItem->qty = 1;
                    $res = $cartItem->save();
                }

                //Update Header
                return redirect()->route('addCart');
            }
            
            else{
                return redirect()->route('addCart');
            }
        }

        else{
            return redirect()->route('LoginUser');
        }
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
    //----------------------------------------------------------UPDATE DATABASE------------------------------------------------------------
}

