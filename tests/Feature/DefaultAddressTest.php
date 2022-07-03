<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use UsersTableSeeder;
use Session;

class DefaultAddressTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test to update default address
     * SHK
     * @return void
     */
    public function test_update_default_address()
    {
        // seed User
        $this->seed(UsersTableSeeder::class);
        // set Session
        $this->withSession(['userId' => -1]);
        $response = $this->from('home')->post(route('update-address'), [
            'Country' => 'Malaysia',
            'State' =>  'Penang',
            'District' => 'Test',
            'Postal' => '113',
            'Address' => 'Test Address'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => -1,
            'country' => 'Malaysia',
            'state' =>  'Penang',
            'district' => 'Test',
            'postcode' => '113',
            'address' => 'Test Address'
        ]);

    }

    /**
     * A test to get default address
     * SHK
     * @return void
     */
    public function test_get_user_address_success()
    {
        // seed User
        $this->seed(UsersTableSeeder::class);
        // set Session
        $this->withSession(['userId' => -1]);
        $getFunction = new \App\Http\Controllers\HomeController;
        $res = $getFunction->getUserAddress();

        $this->assertEquals(true, ($res != null));
    }

    /**
     * A test to get default address failure
     * SHK
     * @return void
     */
    public function test_get_user_address_failure()
    {
        $getFunction = new \App\Http\Controllers\HomeController;
        $res = $getFunction->getUserAddress();

        $this->assertEquals(true, ($res == null));
    }
}
