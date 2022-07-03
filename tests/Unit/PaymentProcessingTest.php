<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Models\Postage;
use App\Models\User;
use App\Models\Stock;
use App\Models\CartItem;
use App\Models\Orders;
use App\Models\OrderItem;
use Session;
use DB;

class PaymentProcessingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_deduct_stock()
    {  
        $oriVal = 10;
        $deductVal = 1;
        $getFunction = new \App\Http\Controllers\PaymentController;
        $newVal = $getFunction-> minusQuantity($oriVal,$deductVal);

        $this->assertEquals(9,$newVal);
    }

    public function test_calculate_postage_price(){
        $getFunction = new \App\Http\Controllers\PaymentController;

        $this->session([
            'numItem' => 5,
            'postageBase' => 3,
            'postageIncrement' => 1
        ]);
        $realPostagePrice = 8;
        $testPostagePrice = $getFunction->calculatePostagePrice();

        $this->assertEquals($realPostagePrice, $testPostagePrice);
    }

    public function test_update_session_data(){
        $postagePrice = 8;
        $getFunction = new \App\Http\Controllers\PaymentController;
        $response = $this->get('/payment');
        $this->withSession(['postagePrice' => 0]);
        $getFunction->UpdateSession($postagePrice);
        $response->assertSessionHas('postagePrice', $postagePrice);
    }

    public function test_get_session_user_id()
    {
        $getFunction = new \App\Http\Controllers\PaymentController;
        $userId = 2;
        $this->withSession(['userId' => 2]);
        $testId = $getFunction->getSessionUserId();
        $this->assertEquals($userId,$testId);
    }

    public function test_reset_session_cart_data(){
        $getFunction = new \App\Http\Controllers\PaymentController;
        $this->withSession([
            'numItem' => 5,
            'priceItem' => 15 
        ]);
        $getFunction->resetSessionCartData();

        $newNumItem = Session::get('numItem');
        $newPriceItem = Session::get('priceItem');

        $this->assertEquals(0,$newNumItem);
        $this->assertEquals(0,$newPriceItem);
    }

    public function test_get_base_price(){
        $getFunction = new \App\Http\Controllers\PaymentController;
        $this->withSession(['priceItem'=>12]);
        $realBasePrice = 12;

        $testBasePrice = $getFunction->getBasePrice();
        $this->assertEquals($realBasePrice,$testBasePrice);
    }

    public function test_get_postage_price(){
        $getFunction = new \App\Http\Controllers\PaymentController;
        $this->withSession(['postagePrice' => 15]);

        $realPostagePrice = 15;
        $testPostagePrice = $getFunction->getPostagePrice();

        $this->assertEquals($realPostagePrice,$testPostagePrice);
    }
}