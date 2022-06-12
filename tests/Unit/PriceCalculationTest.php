<?php

namespace Tests\Unit;

use Tests\TestCase;
use Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriceCalculationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    //use RefreshDatabase;

    //maybe not needed?
    public function test_calculate_add_price() {
        $this -> withSession(['priceItem' => 67]);
        $controller = new \App\Http\Controllers\HomeController;
        $newPrice = $controller->calculateNewPrice(67);
        $this->assertEquals(134,$newPrice);
    }

    public function test_calculate_reduce_price() {
        $this ->withSession(['priceItem' => 134]);
        $controller = new \App\Http\Controllers\HomeController;
        $newPrice = $controller->calculateNewPriceMinus(67);
        $this->assertEquals(67, $newPrice);
    }

    public function test_calculate_new_subtotal_price(){
        $controller = new \App\Http\Controllers\HomeController;
        $subtotalPrice = $controller->calculateNewSubtotalPrice(5, 30);
        $this->assertEquals(150, $subtotalPrice);
    }

    public function test_calculate_new_price_after_delete(){
        $this->withSession(['priceItem' => 200]);
        $controller = new \App\Http\Controllers\HomeController;
        $newPrice = $controller->calculateNewPriceDelete(30, 2);
        $this->assertEquals(140, $newPrice);
    }
}
