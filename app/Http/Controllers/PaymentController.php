<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postage;
use App\Models\User;
use App\Models\Stock;
use App\Models\CartItem;
use App\Models\Orders;
use App\Models\OrderItem;
use Session;
use DB;

class PaymentController extends Controller{

    public function paymentView(Request $requests){
        if(Session::has('userId')){
            // Get User Id
            $userID = Session::get('userId');
            // Get User Shopping Cart Data
            $shoppingCart = DB::table('shopping_cart')
            ->select('shopping_cart.qty', 'shopping_cart.ISBN13', 'shopping_cart.userID', 'stock.coverImg', 'stock.retailPrice')
            ->join('stock', 'shopping_cart.ISBN13', '=', 'stock.ISBN13')
            ->where('shopping_cart.userID', '=', $userID)
            ->get();

            $user = User::where('id','=',$userID)->first();

            $postagePrice = $this->calculatePostagePrice();
            $this->UpdateSession($postagePrice);

            return view("payment")->with(compact('shoppingCart'))->with('user',$user);
        }
    }

    /**
     * Adds stock qty if exists creates new stock if it does not
     *
     * @param  Http\Request
     * @return \Illuminate\Http\Response
     */
    public function processPayment(Request $requests){
        if(Session::has('userId')){
            $userId = $this->getSessionUserId();
            $this->paymentFormValidation($requests);
            $shippingAddress = $this->getSessionShippingAddress();
            isset($shippingAddress['country']);
            $newOrder = new Orders();
            $newOrder->userID = $userId;
            $newOrder->basePrice = $this->getBasePrice();
            $newOrder->postagePrice = $this->getPostagePrice();
            $newOrder->recipientName = $requests->recipientname;
            $newOrder->country = Session::get('shippingCountry');
            $newOrder->state = Session::get('shippingState');
            $newOrder->district = Session::get('shippingDistrict');
            $newOrder->postcode = Session::get('shippingPostcode');
            $newOrder->address = Session::get('shippingAddress');

            $res = $newOrder->save();
            $orderId = Orders::where('userID','=',$userId)->latest('orderID')->limit('1')->pluck('orderID');

            if($res && $orderId){
                $cartItem = CartItem::where('userID','=',$userId)->get();
                foreach($cartItem as $cartItems){
                    $orderItem = new OrderItem();
                    $orderItem->orderID = $orderId[0];
                    $orderItem->ISBN13 = $cartItems->ISBN13;
                    $orderItem->qty = $cartItems->qty;
                    $saveitems = $orderItem->save();
                    
                    if($saveitems){
                    $minusStock = Stock::where('ISBN13','=',$cartItems->ISBN13)->first();
                    $minusStock->qty = $minusStock->qty - $cartItems->qty;
                    $newRes = $minusStock->save();
                    }
                }
                    
                $clearCart = CartItem::where('userID','=',$userId)->delete();
                if($clearCart){
                    $this->resetSessionCartData();
                    return redirect("home")->with('success','Your order has been paid fully and is being processed. We kindly ask for your patience while we are scheduling the delivery of your purchases.');
                }
                else{
                    return redirect("home")->with('fail','Fail to process payment. Please try again');
                }
            }
            else{
                return redirect('payment')->with('fail','Fail to process payment. Please try agaain');
            }
        }

    }

    public function paymentFormValidation(Request $requests){
        $requests->validate([
            'cardnumber' => 'required|min:19|max:19|regex:/[0-9]/',
            'recipientname' => 'required',
            'expirydate' => 'required|min:5|max:5|regex:/^[0-9]/',
            'cvv' => 'required|min:3|max:3|regex:/[0-9]/',
        ]);
    }

    //-------------------------------------- Calculation --------------------------------------------------------------//
    public function calculatePostagePrice(){
        $itemCount = Session::get('numItem');
        $postage_base = Session::get('postageBase');
        $postage_increment = Session::get('postageIncrement');

        $postagePrice = $postage_base + ($postage_increment * $itemCount);

        return $postagePrice;
    }
    
    //-------------------------------------- Session Data -------------------------------------------------------------//
    public function UpdateSession($postagePrice){
        Session::put('postagePrice',$postagePrice);
    }

    public function getSessionUserId(){
        if(Session::has('userId')){
            $userId = Session::get('userId');
        }
        return $userId;
    }

    public function getSessionShippingAddress(){
        if(Session::has('shippingAddress')){
            $shippingAddress = array(
            'country' => Session::get('shippingCountry'),
            'state' => Session::get('shippingState'),
            'district' => Session::get('shippingDistrict'),
            'postcode' => Session::get('shippingPostcode'),
            'address' => Session::get('shippingAddress')
            );

            return $shippingAddress;
        }
    }

    public function resetSessionCartData(){
        Session::put('numItem',0);
        Session::put('priceItem',0);
    }

    public function getBasePrice(){
        if(Session::has('priceItem')){
            $basePrice = Session::get('priceItem');
            return $basePrice;
        }
    }

    public function getPostagePrice(){
        if(Session::has('postagePrice')){
            $postagePrice = Session::get('postagePrice');
            return $postagePrice;
        }
    }
}
?>