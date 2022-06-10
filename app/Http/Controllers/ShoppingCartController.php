<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\User;
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
}
?>