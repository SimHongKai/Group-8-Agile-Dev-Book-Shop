<?php

namespace Tests\Unit;

use Tests\TestCase;
use Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\CartItem;

class CartProcessingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    //use RefreshDatabase;

    public function test_calculate_quantity_header_validation()
    {  
        $this->withSession(['numItem' => 1]);
        $calcQty = new \App\Http\Controllers\HomeController;
        $newQty = $calcQty->calculateNewQuantity();
        $this->assertEquals(2,$newQty);
    }

    public function test_calculate_price_header_validation()
    {  
        $this->withSession(['priceItem' => 4]);
        $calcFunc = new \App\Http\Controllers\HomeController;
        $newPrice = $calcFunc->calculateNewPrice(1);
        $this->assertEquals(5,$newPrice);
    }
    
    public function test_update_session_validation()
    {  
        $price = 8;
        $qty = 5;
        
        $test = new \App\Http\Controllers\HomeController;
        $updatedSession = $test->updateSession(8,5);

        $compareQty = Session::get('numItem');
        $comparePrice = Session::get('priceItem');

        if($compareQty==$qty && $comparePrice==$price){
            $updatedSession=TRUE;
        }
        else{
            $updatedSession=FALSE;
        }
            
        $this->assertEquals(TRUE,$updatedSession);
    }
    
    public function test_book_exist_validation()
    {  
        $userID = 4 ;
        $ISBN13 = 9780786838653;
        
        $getFunction = new \App\Http\Controllers\HomeController;
        $status = $getFunction->checkExist($userID,$ISBN13);

        $this->assertEquals(TRUE,$status);
    }

    public function test_upload_book_to_database()
    {  
        $cartItem = new CartItem();
        $cartItem->userID = "4";
        $cartItem->ISBN13 = "4968726478145";
        $cartItem->qty = 1;
        $getFunction = new \App\Http\Controllers\HomeController;
        $status = $getFunction->uploadDB($cartItem);

        $this->assertEquals(TRUE,$status);
    }

    public function test_user_is_logged_in_validation()
    {  
        $getFunction = new \App\Http\Controllers\HomeController;
        $testLoggedIn = $getFunction->isLoggedIn(2,30,True);
        $this->assertContains(True, $testLoggedIn );
    }


    public function test_user_is_not_logged_in_validation()
    {  
        $getFunction = new \App\Http\Controllers\HomeController;
        $testLoggedIn = $getFunction->isLoggedIn(null,null,False);
        $this->assertContains(False, $testLoggedIn );
    }
}
