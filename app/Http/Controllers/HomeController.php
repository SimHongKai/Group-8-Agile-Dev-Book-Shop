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

    //function to add 1 quantity in the shopping cart
    /*public function addQuantity(Request $request)
    {
        if(Session::has('userId')){
            //Get Value
            $userID = Session::get('userId');
            $ISBN13 = $request->bookISBN;
            $stock = Stock::find($ISBN13);

            //Sum value
            $newPrice = $this-> calculateNewPrice($stock->retailPrice);
            $newItemCount = $this-> calculateNewQuantity();
            $subtotalPrice = 0;
            $subtotalQty = 0;

            //Update session
            $sessionUpdated = $this -> updateSession($newPrice,$newItemCount,$request);
            
            //Upload to database 
            $this -> updateDBadd($userID,$ISBN13);

            $subtotalPrice = $this -> calculateNewSubtotalPrice($updatedNumValue, $stock->retailPrice);
            $subtotalQty = $updatedNumValue;

            // put cart data in array to be returned
            $data = $this -> isLoggedIn2 ($newItemCount, $newPrice, $subtotalPrice, $subtotalQty, True);
            $data = json_encode($data);
            
            return $data;
        }
    }*/
    public function addQuantity(Request $request)
    {
        if(Session::has('userId')){
            //Initial value
            $initialPrice = Session::get('priceItem');
            $initialItemCount = Session::get('numItem');
            $userID = Session::get('userId');
            // Get ISBN13
            $ISBN13 = $request->bookISBN;

            // Get stock data
            $stock = Stock::find($ISBN13);

            //Sum value
            $newPrice = $initialPrice + $stock->retailPrice;
            $newItemCount = $initialItemCount + 1;
            $subtotalPrice = 0;
            $subtotalQty = 0;

            //Update session
            $request->session() -> put('numItem',$newItemCount);
            $request->session() -> put('priceItem',$newPrice);
            
            //Upload to database 
            $existingValue = CartItem::select('qty')->where('userID',$userID) ->Where('ISBN13',$ISBN13) ->get();
            $existingValue = preg_replace('/[^0-9]/','',$existingValue);
            $updatedNumValue =$existingValue+1;

            $subtotalPrice = $updatedNumValue * $stock->retailPrice;
            $subtotalQty = $updatedNumValue;

            CartItem::where('userID',$userID) ->Where('ISBN13',$ISBN13) -> update(['qty' => $updatedNumValue]);

            // put cart data in array to be returned
            $data = array('qty' => $newItemCount, 'price' => $newPrice, 'subtotalPrice' => $subtotalPrice, 'subtotalQty' => $subtotalQty);
            $data = json_encode($data);
            
            return $data;
        }
    }
    
    //function to reduce quantity by 1 in the shopping cart
    /*public function minusQuantity(Request $request)
    {
        if(Session::has('userId')){
            //Get Value
            $userID = Session::get('userId');
            $ISBN13 = $request->bookISBN;
            $stock = Stock::find($ISBN13);

            //Sum value
            $newPrice = $this-> calculateNewPrice($stock->retailPrice);
            $newItemCount = $this-> calculateNewQuantity();
            $subtotalPrice = 0;
            $subtotalQty = 0;

            //Update session
            $sessionUpdated = $this -> updateSession($newPrice,$newItemCount,$request);
            
            //Upload to database 
            $this -> updateDBminus($userID,$ISBN13);

            $subtotalPrice = $this -> calculateNewSubtotalPrice($updatedNumValue, $stock->retailPrice);
            $subtotalQty = $updatedNumValue;

            // put cart data in array to be returned
            $data = $this -> isLoggedIn2 ($newItemCount, $newPrice, $subtotalPrice, $subtotalQty, True);
            $data = json_encode($data);
            
            return $data;
        }
    }*/
    public function minusQuantity(Request $request)
    {
        if(Session::has('userId')){
            //Initial value
            $initialPrice = Session::get('priceItem');
            $initialItemCount = Session::get('numItem');
            $userID = Session::get('userId');
            // Get ISBN13
            $ISBN13 = $request->bookISBN;

            // Get stock data
            $stock = Stock::find($ISBN13);

            //Sum value
            $newPrice = $initialPrice - $stock->retailPrice;
            $newItemCount = $initialItemCount - 1;
            $subtotalPrice = 0;
            $subtotalQty = 0;

            //Update session
            $request->session() -> put('numItem',$newItemCount);
            $request->session() -> put('priceItem',$newPrice);
            
            //Upload to database 
            $existingValue = CartItem::select('qty')->where('userID',$userID) ->Where('ISBN13',$ISBN13) ->get();
            $existingValue = preg_replace('/[^0-9]/','',$existingValue);
            $updatedNumValue =$existingValue-1;
            CartItem::where('userID',$userID) ->Where('ISBN13',$ISBN13) -> update(['qty' => $updatedNumValue]);

            $subtotalPrice = $updatedNumValue * $stock->retailPrice;
            $subtotalQty = $updatedNumValue;

            // put cart data in array to be returned
            $data = array('qty' => $newItemCount, 'price' => $newPrice, 'subtotalPrice' => $subtotalPrice, 'subtotalQty' => $subtotalQty);
            $data = json_encode($data);
            
            return $data;
        }
    }

    //------------------------------------------------------------LOGGED IN------------------------------------------------------------
    public function isLoggedIn($newItemCount,$newPrice,$loggedIn){
        $data = array('qty' => $newItemCount, 'price' => $newPrice, 'login' => $loggedIn);
        return $data;
    }

    /*public function isLoggedIn2($newItemCount, $newPrice, $subtotalPrice, $subtotalQty, $loggedIn){
        $data = array('qty' => $newItemCount, 'price' => $newPrice, 'subtotalPrice' => $subtotalPrice, 'subtotalQty' => $subtotalQty, 'login' => $loggedIn);
        return $data;
    }*/

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

    /*public function calculateNewQuantityMinus() {
        $initialItemCount = Session::get('numItem');
        $newQuantity=$initialItemCount-1;
        return $newQuantity;
    }

    public function calculateNewSubtotalPrice($updatedNumValue, $itemPrice) {
        $subtotalPrice = $updatedNumValue * $itemPrice;
        return $subtotalPrice;
    }*/

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

    /*public function updateDBadd($userID,$ISBN13){
        $existingValue = CartItem::select('qty')->where('userID',$userID) ->Where('ISBN13',$ISBN13) ->get();
        $existingValue = preg_replace('/[^0-9]/','',$existingValue);
        $updatedNumValue =$existingValue+1;
        CartItem::where('userID',$userID) ->Where('ISBN13',$ISBN13) -> update(['qty' => $updatedNumValue]);
        return $updatedNumValue;
    }

    public function updateDBminus($userID,$ISBN13){
        $existingValue = CartItem::select('qty')->where('userID',$userID) ->where('ISBN13',$ISBN13) ->get();
        $existingValue = preg_replace('/[^0-9]/','',$existingValue);
        $updatedNumValue =$existingValue-1;
        CartItem::where('userID',$userID) ->where('ISBN13',$ISBN13) -> update(['qty' => $updatedNumValue]);
        return $updatedNumValue;
    }*/

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
            $userID = Session::get('userId');
            $shoppingCart = DB::table('shopping_cart')
            ->select('shopping_cart.qty', 'shopping_cart.ISBN13', 'shopping_cart.userID', 'stock.coverImg', 'stock.retailPrice')
            ->join('stock', 'shopping_cart.ISBN13', '=', 'stock.ISBN13')
            ->where('shopping_cart.userID', '=', $userID)
            ->get();
            return view("shoppingCart")->with(compact('shoppingCart'));
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