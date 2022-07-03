<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
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
}
