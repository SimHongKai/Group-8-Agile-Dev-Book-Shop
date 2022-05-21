<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use DB;

class StockController extends Controller
{
    /**
     * Gets list of all stock
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function addStocksView(){
        return view ('addStocks');
    }

    public function editStocksView(){
        return view ('editStocks');
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
        if($request->hasFile('coverImg')) {
            $image = $request->file('coverImg');
            $image_name = $request->ISBN13.'-'.$image->getClientOriginalName();
        }
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

            //check if coverImg is inputted, if no then no change
            if ($request->hasFile('coverImg')) {
                //check current image for pending entry
                $current_image = Stock::find($request->ISBN13)->coverImg;
                if($request->coverImg != $current_image) {
                    //delete previous image if image already exists and is not currently in use by another book
                    $prev_path = public_path().'/book_covers/'.$current_image;
                    if (file_exists($prev_path) && $prev_path != public_path().'/book_covers/no_book_cover.jpg'){
                        @unlink($prev_path);
                    }
                }
                //upload image to public/book_covers if it doesn't already exist
                $path = public_path().'/book_covers';
                $image->move($path, $image_name);
                $checkStock->coverImg = $image_name;
                $prev_path = $path;
            }
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
            
            if($request->hasFile('coverImg')) {
                $path = public_path().'/book_covers';
                $image->move($path, $image_name);
                $stock->coverImg = $image_name;
            }
            else {
                $stock->coverImg = 'no_book_cover.jpg';
            }
 
            $res = $stock->save();
        } 

        if($res){
            return redirect('stocks')->with('success', 'Stock has been updated Succesfully!');
        }

        else{
            return redirect('addStocks')->with('fail','Fail to Update Stock');
        }
        
        
    }

    /** 
     * Edit Stock Details Except Stock ISBN13 And Quantity
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function editStock(Request $request)
    {
        //define image file and get original name from encryption
        if($request->hasFile('coverImg')) {
            $image = $request->file('coverImg');
            $image_name = $request->ISBN13.'-'.$image->getClientOriginalName();
        }
        //validate book info before storing to database
        $request->validate([
            'ISBN13'=>'required|min:13|max:13|regex:/[0-9]/',
            'bookName'=>'required',
            'bookDesc' => 'required',
            'bookAuthor' => 'required|regex:/[a-z]/|regex:/[A-Z]/',
            'publicationDate'=>'required|date_format:Y-m-d|before_or_equal:today',
            'retailPrice'=>'required|numeric|min:20|max:100',
            'tradePrice'=>'required|numeric|min:20|max:100',
        ]);
        //Create new stock object and check if exists
        $checkStock = Stock::where('ISBN13','=',$request->ISBN13)->first();
        // Update Stock Details If Exist
        if($checkStock){
            $checkStock->bookName = $request->bookName;
            $checkStock->bookDescription = $request->bookDesc;
            $checkStock->bookAuthor = $request->bookAuthor;
            $checkStock->publicationDate = $request->publicationDate;
            $checkStock->tradePrice = $request->tradePrice;
            $checkStock->retailPrice = $request->retailPrice;

            //check if coverImg is inputted, if no then no change
            if ($request->hasFile('coverImg')) {
                //check current image for pending entry
                $current_image = Stock::find($request->ISBN13)->coverImg;
                if($request->coverImg != $current_image) {
                    //delete previous image if image already exists and is not currently in use by another book
                    $prev_path = public_path().'/book_covers/'.$current_image;
                    if (file_exists($prev_path) && $prev_path != public_path().'/book_covers/no_book_cover.jpg'){
                        @unlink($prev_path);
                    }
                }
                //upload image to public/book_covers if it doesn't already exist
                $path = public_path().'/book_covers';
                $image->move($path, $image_name);
                $checkStock->coverImg = $image_name;
                $prev_path = $path;
            }
            $res = $checkStock->save();
        // Return Book Not Found Message If Doesn't
        }else {
            return redirect('editStocks')->with('fail','Book does not exist!');
        } 

        if($res){
            return redirect('stocks')->with('success', 'Stock has been updated Succesfully!');
        }

        else{
            return redirect('editStocks')->with('fail','Unable to Edit Book Details!');
        }
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

    public function obtainStock() {
        $stocks = DB::select('select * from stock');
        return view('stocks')->with(compact('stocks'))->with('success', 'Stock has been updated Succesfully!');
    }

    public function stockFiltering(Request $request) {
        //validate book info
        $request->validate([
            'qty'=>'numeric|min:0'
        ]);

        $title="";
        $minQty=0;
        $maxQty=0;

        $filter=true;

        //if request not empty assign variables
         if (isset($request->bookName)){
            $title = $request->bookName;
        }

        if (isset($request->qty)) {
            $minQty = $request->qty;
        }
        
        $stocks = DB::table('stock')
                    /* ->where('bookName','LIKE',$title) */
                    ->where('qty','>=',$minQty)
                    ->get();

        return view('stocks')->with(compact('stocks'))->with('success', 'Stock has been updated Succesfully!');
    }
}
