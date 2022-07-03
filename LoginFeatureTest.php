<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use UsersTableSeeder;
use Tests\TestCase; 

class LoginFeatureTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_signin_success()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => 'test@gmail.com',
            'userPassword' => 'Test_12345'
        ]);
        $response->assertRedirect('/home');
    }

    public function test_signin_password_fail()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => 'wongkevin206@gmail.com',
            'userPassword' => 'test'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.login');
    }

    public function test_signin_account_not_exist_fail()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => 'pewtest@gmail.com',
            'userPassword' => 'test'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.login');
    }

    public function test_signin_input_empty_fail()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => '',
            'userPassword' => ''
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('auth.login');
    }
    
    public function test_signin_email_format_fail()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => 'test',
            'userPassword' => 'Test_12345'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('auth.login');
    }

    public function test_signin_password_format_fail()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => 'test@gmail.com',
            'userPassword' => 'testingggggggggggggggggg'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('auth.login');
    }

    public function test_signin_password_character_number_fail()
    {
        $response = $this->from('auth.login')->post(route('login-user'), [
            'userEmail' => 'test@gmail.com',
            'userPassword' => 'hi'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('auth.login');
    }

    public function test_signup_success()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'testing123',
            'userEmail' => '321testingdelete@gmail.com',
            'userPassword' => 'Test12345@',
            'privilige'=>'2'
        ]);
        //$response->assertRedirect('/home');
        $response->assertRedirect('auth.registration');
    }

    public function test_signup_empty_fail()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'',
            'userEmail' => '',
            'userPassword' => '',
            'privilige'=>''
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.registration');
    }

    public function test_signup_email_unique_fail()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'testing999',
            'userEmail' => 'wongkevin206@gmail.com',
            'userPassword' => 'Test@12345',
            'privilige'=>'1'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.registration');
    }

    public function test_signup_email_format_fail()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'testing999',
            'userEmail' => 'notexist',
            'userPassword' => 'Test@12345',
            'privilige'=>'1'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.registration');
    }

    public function test_signup_password_character_number_fail()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'testing999',
            'userEmail' => 'notexist@gmail.com',
            'userPassword' => 'st',
            'privilige'=>'1'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.registration');
    }

    public function test_signup_password_format_fail()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'testing999',
            'userEmail' => 'notexist@gmail.com',
            'userPassword' => 'Test',
            'privilige'=>'1'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.registration');
    }

    public function test_signup_privilige_format_fail()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'testing999',
            'userEmail' => 'notexist@gmail.com',
            'userPassword' => 'Test@12345',
            'privilige'=>'dsd'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.registration');
    }

    public function test_signup_privilige_value_fail()
    {
        $response = $this->from('auth.registration')->post(route('register-user'), [
            'userName'=>'testing999',
            'userEmail' => 'notexist@gmail.com',
            'userPassword' => 'Test@12345',
            'privilige'=>'9'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('auth.registration');
    }
}