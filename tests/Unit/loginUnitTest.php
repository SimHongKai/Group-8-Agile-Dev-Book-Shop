<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use UsersTableSeeder;
use App\Models\User;
use Tests\TestCase; 
use Session;

class loginUnitTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sign_up_upload_database_function()
    {
        $user = new User();
        $user->userName = 'testing456';
        $user->userEmail = '456testingdelete@gmail.com';
        $user->userPassword = 'Test12345@';
        $user->userPrivilige = '2';
        $user->country = "test";
        $user->state = "test";
        $user->district = "test";
        $user->postcode = 0;
        $user->address = "test";
        $getFunction = new \App\Http\Controllers\CustomAuthController;
        $status = $getFunction-> signUpFunction($user);

        $this->assertEquals(TRUE,$status);
    }

    public function test_sign_in_find_user_function(){
        $email="test@gmail.com";
        $getFunction = new \App\Http\Controllers\CustomAuthController;
        $userStatus = $getFunction -> signInUserFoundFunction($email);
        if($userStatus){
            $checkStatus=TRUE;
        }

        $this->assertEquals(TRUE,$checkStatus);
    }

    public function test_sign_in_validate_password_function(){
        $typepassword = "Test_12345";
        $dbpassword = "$2y$10\$eD/82W/KtY09dx//poYVTeb5xd5.am04UgywTj.HKJHteg5FaK2.6";
        $getFunction = new \App\Http\Controllers\CustomAuthController;
        $passwordStatus = $getFunction -> signInPassValidateFunction($typepassword, $dbpassword);
        if($passwordStatus){
            $passwordStatus=TRUE;
        }

        $this->assertEquals(TRUE,$passwordStatus);
    }

    public function test_update_session_sign_in_function()
    {
        $userID = "1";
        $userPriv = "1";
        $itemAmount = "4";
        $sumTotal = "100";
        $getFunction = new \App\Http\Controllers\CustomAuthController;
        $getFunction -> updateSessionSignIn($userID,$userPriv,$itemAmount,$sumTotal);
       
        $compareuserID = Session::get('userId');
        $compareuserPriv = Session::get('userPrivilige');
        $compareitemAmount = Session::get('numItem');
        $comparesumTotal = Session::get('priceItem');

        if($userID== $compareuserID && $userPriv== $compareuserPriv && $itemAmount== $compareitemAmount && $sumTotal== $comparesumTotal ){
            $checkStatus=TRUE;
        }
        else{
            $checkStatus=FALSE;
        }

        $this->assertEquals(TRUE,$checkStatus);
    }

}