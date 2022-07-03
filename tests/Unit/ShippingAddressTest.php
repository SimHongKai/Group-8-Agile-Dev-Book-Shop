<?php

namespace Tests\Unit;

use Tests\TestCase;
use Session;

class ShippingAddressTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_session_userid()
    {
        $homeController = new \App\Http\Controllers\HomeController;
        $userId = 2;
        $this->withSession(['userId' => 2]);
        $testId = $homeController->getSessionUserId();
        $this->assertEquals($userId,$testId);
    }
}
