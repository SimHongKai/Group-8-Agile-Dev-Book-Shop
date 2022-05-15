<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Gets list of all stock
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function allStock(){

    }


    /**
     * Adds stock qty if exists creates new stock if it does not
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function addStock(Request $request)
    {
        //define image file and get original name from encryption
        $image = $request->file('coverImg');
        $image_name = $request->ISBN13.'-'.$image->getClientOriginalName();

        //validate book info before storing to database
        $request->validate([
            'ISBN13'=>'required|min:13|max:13|regex:/[0-9]/',
            'bookName'=>'required',
            'bookDesc' => 'required',
            'bookAuthor' => 'required|regex:/[a-z]/|regex:/[A-Z]/',
            'publicationDate'=>'required|date_format:Y-m-d|before_or_equal:today',
            'retailPrice'=>'required|numeric|min:20|max:100',
            'tradePrice'=>'required|numeric|min:20|max:100',
            'qty'=>'required|numeric|min:0'
        ]);
        //Create new stock object and check if exists
        $checkStock = Stock::where('ISBN13','=',$request->ISBN13)->first();
        // Update Qty if exists
        if($checkStock){
            $checkStock->ISBN13 = $request->ISBN13;
            $checkStock->bookName = $request->bookName;
            $checkStock->bookDescription = $request->bookDesc;
            $checkStock->bookAuthor = $request->bookAuthor;
            $checkStock->publicationDate = $request->publicationDate;
            $checkStock->tradePrice = $request->tradePrice;
            $checkStock->retailPrice = $request->retailPrice;
            $checkStock->qty = $checkStock->qty + $request->qty;

            //check current image for pending entry
            $current_image = Stock::find($request->ISBN13)->coverImg;
            if($request->coverImg != $current_image) {
                //delete previous image if image already exists and is not currently in use by another book
                $prev_path = public_path().'/book_covers/'.$current_image;
                if (file_exists($prev_path)){
                    @unlink($prev_path);
                }
            }
            //upload image to public/book_covers if it doesn't already exist
            $path = public_path().'/book_covers';
            $image->move($path, $image_name);

            $checkStock->coverImg = $image_name;

            $prev_path = $path;

            $res = $checkStock->save();
        // Create new record if doesn't
        }else {
            $stock = new Stock();
            $stock->ISBN13 = $request->ISBN13;
            $stock->bookName = $request->bookName;
            $stock->bookDescription = $request->bookDesc;
            $stock->bookAuthor = $request->bookAuthor;
            $stock->publicationDate = $request->publicationDate;
            $stock->tradePrice = $request->tradePrice;
            $stock->retailPrice = $request->retailPrice;
            $stock->qty = $request->qty;
            
            $path = public_path().'/book_covers';
            $image->move($path, $image_name);

            $stock->coverImg = $image_name;
 
            $res = $stock->save();
        } 

        if($res){
            return redirect('stocks')->with('success', 'Stock has been updated Succesfully!');
        }

        else{
            return redirect('addStocks')->with('fail','Fail to Update Stock');
        }
        
        
    }

    public function editStock(Request $request){

    }

    /**
     * Gets the Specified Stock
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function getStock(Request $request)
    {
        //Create new stock object and check if exists
        if($request->has(['ISBN13']) && $request->ISBN13!=null)
            $stock = Stock::find($request->ISBN13);
            // Update Qty if exists
            if($stock){
                return $stock;
            }
            return null;
    }
}
