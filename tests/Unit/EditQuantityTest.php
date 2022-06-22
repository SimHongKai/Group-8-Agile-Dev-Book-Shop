<?php

namespace Tests\Unit;

use Tests\TestCase;
use Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditQuantityTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    //use RefreshDatabase;

    public function test_calculate_new_quantity_add_button_validation () {
        $this->withSession(['numItem' => 10]);
        $controller = new \App\Http\Controllers\HomeController;
        $newQuantity = $controller->calculateNewQuantity(1);
        $this->assertEquals(11,$newQuantity);
    }

    public function test_calculate_new_quantity_minus_button_validation () {
        $this->withSession(['numItem' => 5]);
        $controller = new \App\Http\Controllers\HomeController;
        $newQuantity = $controller->calculateNewQuantityMinus(1);
        $this->assertEquals(4,$newQuantity);
    }

    public function test_calculate_new_quantity_delete_button_validation () {
        $this->withSession(['numItem' => 30]);
        $controller = new \App\Http\Controllers\HomeController;
        $newQuantity = $controller->calculateNewQuantityDelete(20);
        $this->assertEquals(10,$newQuantity);
    }
}