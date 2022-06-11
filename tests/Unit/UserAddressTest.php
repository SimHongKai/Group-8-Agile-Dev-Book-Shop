<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserAddressTest extends TestCase
{
    /**
     * test for checking user Address
     *
     * @dataProvider validAddressProvider
     * @return void
     */
    public function test_user_address_exists($address)
    {
        $getFunction = new \App\Http\Controllers\HomeController;
        $res = $getFunction->userAddressExists($address);

        $this->assertEquals(true, $res);
    }

    /**
     * test for checking empty user address
     *
     * @dataProvider emptyAddressProvider
     * @return void
     */
    public function test_user_address_empty($address)
    {
        $getFunction = new \App\Http\Controllers\HomeController;
        $res = $getFunction->userAddressExists($address);

        $this->assertEquals(false, $res);
    }

    public function validAddressProvider()
    {
        return array(
            array("Test Address"),
            array("null")
        );
    }

    public function emptyAddressProvider()
    {
        return array(
          array(""),
          array(null),
          array(" ")
        );
    }
}