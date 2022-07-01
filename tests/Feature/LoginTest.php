<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use UsersTableSeeder;
use Tests\TestCase; 

class LoginTest extends TestCase
{

    /**
     * Test Login Successful
     * SHK
     * @return void
     */
    public function test_login_successful()
    {
        // Run seeder to create user account
        $this->seed();

        $response = $this->post('/login-user', [
            'userEmail' => 'PotatoSim@gmail.com',
            'userPassword' => 'PotatoSim@10'
        ]);

        $response->assertRedirect('/home');
    }

    /**
     * Test Login Fail
     * SHK
     * @return void
     */
    public function test_login_fail()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => 'PotatoSim@gmail.com',
            'userPassword' => 'PotatoSim@0'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.login');
    }
}
