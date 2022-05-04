<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }

    /**
     * Adds stock qty if exists creates new stock if it does not
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function addStock(Stock $stock)
    {
        //validate book info before storing to database
        $request->validate([
            'userID'=>'required|unique:users',
            'userName'=>'required|regex:/^[a-zA-Z]+$/u',
            'userEmail' => 'required|email',
            'userPassword' => 'required|min:8|max:12|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!_%*#?&]/',
            'privilige'=>'required|gt:0|lt:3'
        ]);
        //Create new stock object and check if exists

        // Create new record if doesn't


        // Update Qty if exists
        $user = new User();
        $user->userID = $request->userID;
        $user->userName = $request->userName;
        $user->userEmail = $request->userEmail;
        $user->userPassword = Hash::make($request->userPassword);
        $user->userPrivilige = $request->privilige;
        $user->country = "";
        $user->state = "";
        $user->district = "";
        $user->postcode = 0;
        $user->address = "";
        $res = $user->save();

        if($res){
            return back() ->with('success','You have registered successfully');
        }

        else{
            return back()->with('fail', 'Something Wrong');
        }
    }
}
