<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use UsersTableSeeder;
use StockTableSeeder;
use Tests\TestCase;

class DatabaseTableTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Users Table Exists
     *
     * @return void
     */
    public function test_users_table(){
        
        $this->seed(UsersTableSeeder::class);
        $this->assertDatabaseHas('users', [
            'username' => 'testname'
        ]);

    }

    /**
     * Test Stock Table Exists
     *
     * @return void
     */
    public function test_stock_table(){
        
        $this->seed(StockTableSeeder::class);
        $this->assertDatabaseHas('stock', [
            'ISBN13' => 'testISBN12345',
            'bookName' => 'testName',
            'bookAuthor' => 'testAuthor',
        ]);

    }

    /**
     * Test User privilge Table exists and there is default privilige values
     *
     * @return void
     */
    public function test_user_privilige_table(){
        
        $this->assertDatabaseHas('userprivilige', [
            'priviligeInt' => '1',
            'priviligeText' => 'user'
        ]);

        $this->assertDatabaseHas('userprivilige', [
            'priviligeInt' => '2',
            'priviligeText' => 'admin'
        ]);

    }

    /**
     * Test postage_prive Table exists and there is default privilige values
     *
     * @return void
     */
    public function test_postage_price_table(){
        
        $this->assertDatabaseHas('postage_price', [
            'local_base' => '3',
            'local_increment' => '1',
            'international_base' => '10',
            'international_increment' => '3'
        ]);

    }
    

}
