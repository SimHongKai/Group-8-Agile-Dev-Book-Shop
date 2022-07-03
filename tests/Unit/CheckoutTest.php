<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Session;

class CheckoutTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_get_existing_value_validation()
    {  
        $getFunction = new \App\Http\Controllers\ShoppingCartController;
        $data = $getFunction->getIntegerForExistingValue("hello123");
        $this->assertEquals(123,$data);
    }

    public function test_get_stock_value_validation()
    {  
        $getFunction = new \App\Http\Controllers\ShoppingCartController;
        $data = $getFunction->getIntegerForStockValue("testing321");
        $this->assertEquals(321,$data);
    }

    public function test_compare_values_validation()
    {  
        $getFunction = new \App\Http\Controllers\ShoppingCartController;
        $data = $getFunction->compareExistingStockVal(6,4);
        $this->assertEquals(TRUE,$data);
    }

    public function test_add_to_insufficient_book_array_validation()
    {  
        $getFunction = new \App\Http\Controllers\ShoppingCartController;
        $insufficientStock = array();
        $data = $getFunction->addInsufficientBookToArray($insufficientStock,"test",1);
        $status = FALSE;
        if(!empty($data))
            $status = TRUE;

        $this->assertEquals(TRUE,$status);
    }
    
    public function test_calculate_new_price_validation()
    {  
        $getFunction = new \App\Http\Controllers\ShoppingCartController;
        $data = $getFunction->calculateNewPrice(1,1,2);
        $this->assertEquals(3,$data);
    }

    public function test_calculate_new_quantity_validation()
    {  
        $getFunction = new \App\Http\Controllers\ShoppingCartController;
        $data = $getFunction->calculateNewQuantity(1,1);
        $this->assertEquals(2,$data);
    }

    public function test_update_session_validation()
    {  
        $price = 8;
        $qty = 5;
        
        $test = new \App\Http\Controllers\ShoppingCartController;
        $updatedSession = $test->updateSession(8,5);
       
        $comparePrice = Session::get('priceItem');
        $compareQty = Session::get('numItem');

        if($compareQty==$qty && $comparePrice==$price){
            $updatedSession=TRUE;
        }
        else{
            $updatedSession=FALSE;
        }
            
        $this->assertEquals(TRUE,$updatedSession);
    }


    public function test_header_update_validation()
    {  
        $getFunction = new \App\Http\Controllers\ShoppingCartController;
        $getData = $getFunction->updateHeader(1,2,True);
        $compareData =  ["qty" => 1, "price" => 2, "login" => TRUE];
        $this->assertEquals($compareData,$getData);
    }
}
