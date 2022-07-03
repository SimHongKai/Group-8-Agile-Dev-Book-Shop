<?php

namespace Tests\Unit;

use Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * Test get order data
     * SHK
     * @return void
     */
    public function test_get_order_data_success()
    {
        $getFunction = new \App\Http\Controllers\PaymentController;
        $res = $getFunction->getOrder(1);
        $this->assertTrue(($res != null));
    }

     /**
     * Test get order data failure
     *
     * @return void
     */
    public function test_get_order_data_failure()
    {
        $getFunction = new \App\Http\Controllers\PaymentController;
        $res = $getFunction->getOrder(-1);
        $this->assertTrue(($res == null));
    }

    /**
     * Test get order data success
     *
     * @return void
     */
    public function test_get_order_item_data_success()
    {
        $getFunction = new \App\Http\Controllers\PaymentController;
        $res = $getFunction->getOrderItems(1);
        $this->assertTrue(($res != null));
    }

    /**
     * Test get order data failure
     *
     * @return void
     */
    public function test_get_order_item_data_failure()
    {
        $getFunction = new \App\Http\Controllers\PaymentController;
        $res = $getFunction->getOrderItems(-1);
        $this->assertTrue(($res->count() == 0));
    }

    /**
     * Test compose EmailBody
     *
     * @return void
     */
    public function test_compose_email_body()
    {
        $getFunction = new \App\Http\Controllers\PaymentController;
        $res = $getFunction->composeEmailBody(1);
        if($res){
            $res = true;
        }
        $this->assertTrue($res);
    }
}
