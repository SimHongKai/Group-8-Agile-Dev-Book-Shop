<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\StockController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CustomAuthController::class,'login']);

//Linked with CustomAuthController, will redirect to the page pressed
Route::get('/login', [CustomAuthController::class, 'login']);
Route::get('/registration',[CustomAuthController::class, 'registration']);
Route::post('/register-user',[CustomAuthController::class,'registerUser'])->name('register-user');
Route::post('/login-user',[CustomAuthController::class,'loginUser'])->name('login-user');
Route::get('/logout',[CustomAuthController::class,'logout']);
Route::get('/home',[CustomAuthController::class,'home']);

//Route for stocks
Route::post('/add-stock',[StockController::class,'addStock'])->name('add-stock');
Route::post('/edit-stock',[StockController::class,'editStock'])->name('edit-stock');
Route::get('/stocks',[StockController::class,'obtainStock']);
Route::post('/stocks',[StockController::class,'stockFiltering'])->name('stock-filtering');

//Route for xmlhttpRequest
Route::post('/addStocks/get-stock', [StockController::class,'getStock']);
Route::post('/editStocks/get-stock', [StockController::class,'getStock']);
// General Route for moving to new pages (dev and testing only, need comment out)
/* Route::get('/{new_page}',[CustomAuthController::class,'new_page']);    */ 