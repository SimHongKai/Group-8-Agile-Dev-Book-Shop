<?php

namespace Tests\Unit;

use Tests\TestCase;

class HTTPTest extends TestCase
{
    /**
     * Test shopping cart route
     * SHK
     * @return void
     */
    public function test_shopping_cart_redirect_login()
    {
        $response = $this->get('/shoppingCart');

        $response->assertRedirect('/login');
        //$repsonse->assertStatus('200');
    }

    /**
     * Test shopping cart route
     *
     * @return void
     */
    public function test_home_route()
    {
        $response = $this->get('/home');
        
        $response->assertStatus(200);
        $response->assertViewHas('stocks');
    }

    // public function test_users_table(){
    //     $this->assertDatabaseHas('users', [
    //         'username' => 'testname'
    //     ]);
    // }

}
