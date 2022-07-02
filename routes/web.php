<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\PaymentController;


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
Route::get('/login', [CustomAuthController::class, 'login'])->name('LoginUser');
Route::get('/registration',[CustomAuthController::class, 'registration']);
Route::post('/register-user',[CustomAuthController::class,'registerUser'])->name('register-user');
Route::post('/login-user',[CustomAuthController::class,'loginUser'])->name('login-user');
Route::get('/logout',[CustomAuthController::class,'logout']);
Route::get('/home',[CustomAuthController::class,'home']);

//Home Controller
Route::post('/home/add-to-cart', [HomeController::class,'processCart'])->name('addCart');
Route::get('/shoppingCart', [HomeController::class,'shoppingCartView'])->name('shoppingCart');
Route::post('/checkout', [ShoppingCartController::class,'checkoutView'])->name('checkout');
//Route::get('/home', [\App\Http\Controllers\HomeController::class,'loadNewCart'])->name('loadCart');

//Route for Checkout
Route::get('/checkout', [ShoppingCartController::class,'checkoutView'])->name('return-to-checkout');
Route::get('/payment', [PaymentController::class, 'paymentView'])->name('payment');

//Route for Payment
Route::post('/payment',[PaymentController::class, 'processPayment'])->name('submitpayment');

//Route to add/minus/remove items
Route::post('/shoppingCart/add-quantity', [HomeController::class,'addQuantity'])->name('addQuantity');
Route::post('/shoppingCart/minus-quantity', [HomeController::class,'minusQuantity'])->name('minusQuantity');
Route::post('/shoppingCart/remove-entry',[HomeController::class,'removeEntry'])->name('removeEntry');

//Route for stocks
Route::get('/addStocks', [StockController::class,'addStocksView'])->name('addStocks');
Route::get('/editStocks', [StockController::class,'editStocksView'])->name('editStocks');
Route::post('/add-stock',[StockController::class,'addStock'])->name('add-stock');
Route::post('/edit-stock',[StockController::class,'editStock'])->name('edit-stock');
Route::get('/stocks',[StockController::class,'obtainStock']);
Route::post('/stocks',[StockController::class,'stockFiltering'])->name('stock-filtering');
Route::get('/stockDetail/{ISBN13}', [StockController::class,'viewStockDetails'])->name('stockDetails');
Route::get('/bookDetail/{ISBN13}', [StockController::class,'viewBookDetails'])->name('bookDetails');

//Route for Cart
Route::post('/shoppingCart',[HomeController::class,'updateShippingAddress'])->name('update-address');

//Route for xmlhttpRequest
Route::post('/addStocks/get-stock', [StockController::class,'getStock']);
Route::post('/editStocks/get-stock', [StockController::class,'getStock']);
Route::post('/shoppingCart/get-user-address', [HomeController::class,'getUserAddress']);

//Email route
Route::get('/send-email', [EmailController::class,'sendEmail']);