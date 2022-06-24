<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Postage;
use App\Models\Stock;
use Session;
use DB;

class ShoppingCartController extends Controller
{
    /**
     * Add new shipping address
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateShippingAddress(Request $request){
        // Get Logged In User Id
        $userId = $this->getSessionUserId();

        // Validate Shipping Address Info
        $this->validateShippingAddress($request);

        // Save User New Shipping Address
        $newAddress = User::where('id','=',$userId)->first();
        // Upload Shipping Address to Database
        $newAddress->country = $request->Country;
        $newAddress->State = $request->State;
        $newAddress->district = $request->District;
        $newAddress->postcode = $request->Postal;
        $newAddress->address = $request->Address;
        $res = $newAddress->save();
        
        if($res){
            return redirect('shoppingCart')->with('success', 'Address has been added successfully');
        }

        else{
            return redirect('shoppingCart')->with('fail','Fail to Add Address');
        }
    }

    protected function getSessionUserId(){
        if(Session::has('userId')){
            $userId = Session::get('userId');
        }
        return $userId;
    }

    protected function validateShippingAddress(Request $request){
        $request->validate([
            'Country' => 'required|min:0|max:100|',
            'State' =>  'required|min:0|max:100|',
            'District' => 'required|min:0|max:100|',
            'Postal' => 'required|min:3|max:50|',
            'Address' => 'required|min:0|max:200|',
        ]);
    }

    public function checkoutView(Request $request){
        $insufficientStock = $this->adjustOutofStock();
        if(Session::has('userId')){
            $userID = Session::get('userId');
            $shoppingCart = DB::table('shopping_cart')
            ->select('shopping_cart.qty', 'stock.bookName', 'shopping_cart.ISBN13', 'shopping_cart.userID', 'stock.coverImg', 'stock.retailPrice')
            ->join('stock', 'shopping_cart.ISBN13', '=', 'stock.ISBN13')
            ->where('shopping_cart.userID', '=', $userID)
            ->get();
            $postage = Postage::get();
            return view("checkout")->with(compact('shoppingCart'))->with(compact('postage'))->with(compact('insufficientStock'));
        }else{
            return redirect()->route('checkout');
        }
    }

    public function adjustOutofStock(){
        $userId = $this->getSessionUserId();
        $newQty=0;
        $newPrice=0;
        $res=FALSE;
        $insufficientStock = "";

        $shoppingCartItems = DB::table('shopping_cart')
            ->select('shopping_cart.qty', 'shopping_cart.ISBN13', 'shopping_cart.userID')
            ->where('shopping_cart.userID', '=', $userId)
            ->get();
    
        foreach($shoppingCartItems as $shoppingCarts) {
            $existingCartValue = CartItem::select('qty')->where('userID',$userId) ->Where('ISBN13',$shoppingCarts->ISBN13) ->get();
            $existingCartValue = preg_replace('/[^0-9.]/','',$existingCartValue);

            $StockCartValue = Stock::select('qty')->Where('ISBN13',$shoppingCarts->ISBN13) ->get();
            $StockCartValue = preg_replace('/[^0-9.]/','',$StockCartValue);

            if($existingCartValue>$StockCartValue){
                $newQty = $newQty + $StockCartValue;
                CartItem::where('userID',$userId) ->Where('ISBN13',$shoppingCarts->ISBN13) -> update(['qty' => $StockCartValue]);
                $itemRetailPrice = Stock::select('retailPrice')->Where('ISBN13',$shoppingCarts->ISBN13) ->get();
                $itemRetailPrice = preg_replace('/[^0-9.]/','',$itemRetailPrice);
                $newPrice = ($itemRetailPrice * $StockCartValue)+$newPrice;
                $qtyChanged = $StockCartValue - $existingCartValue;
                $bookName = Stock::select('bookName')->Where('ISBN13',$shoppingCarts->ISBN13) ->get();
                $bookName = preg_replace('/[^0-9.]/','',$bookName);
                $insufficientStock = array('book_name' => $shoppingCarts->ISBN13, 'book_ISBN13' => $shoppingCarts->ISBN13, 'stock_qty' => $StockCartValue,'qty_changed' => $qtyChanged);
            }

            else{
                $newQty = $newQty + $StockCartValue;
                $itemRetailPrice = Stock::select('retailPrice')->Where('ISBN13',$shoppingCarts->ISBN13) ->get();
                $itemRetailPrice = preg_replace('/[^0-9.]/','',$itemRetailPrice);
                $newPrice = ($itemRetailPrice * $StockCartValue)+$newPrice;
            }
        }
        
        Session:: put('numItem',$newQty);
        Session:: put('priceItem',$newPrice);
        $data = $this -> updateHeader ($newQty,$newPrice,True);
        return $insufficientStock;
    }

    public function updateHeader($newItemCount,$newPrice,$loggedIn){
        $data = array('qty' => $newItemCount, 'price' => $newPrice, 'login' => $loggedIn);
        return $data;
    }
}
?>