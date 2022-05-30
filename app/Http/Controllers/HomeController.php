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
            //Initial value
            $initialPrice = Session::get('priceItem');
            $initialItemCount = Session::get('numItem');
            $userID = Session::get('userId');
            //Get value
            $selectedPrice = $request->addButton;
            $ISBNValue=$request->bookISBN;

            //Sum value
            $newPrice = $initialPrice + $selectedPrice;
            $newItemCount = $initialItemCount + 1;

            //Update session
            $request->session() -> put('numItem',$newItemCount);
            $request->session() -> put('priceItem',$newPrice);
            
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
            return redirect()->route('LoginUser');
        }
    }
}

//add to database and get value of user id