<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postage;
use App\Models\User;
use Session;
use DB;

class PaymentController extends Controller{

    public function paymentView(Request $requests){
        if(Session::has('userId')){
            $userID = Session::get('userId');
            $shoppingCart = DB::table('shopping_cart')
            ->select('shopping_cart.qty', 'shopping_cart.ISBN13', 'shopping_cart.userID', 'stock.coverImg', 'stock.retailPrice')
            ->join('stock', 'shopping_cart.ISBN13', '=', 'stock.ISBN13')
            ->where('shopping_cart.userID', '=', $userID)
            ->get();
            $postage = Postage::get();
            $user = User::where('id','=',$userID)->first();
            return view("payment")->with(compact('shoppingCart'))->with(compact('postage'))->with('user',$user);
        }
    }
}
?>