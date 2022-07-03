<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Stock;
use StockTableSeeder;

class AddStockTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Add Stocks View
     * SHK
     * @return void
     */
    public function test_add_stocks_view()
    {
        $response = $this->get(route('addStocks'));

        $response->assertStatus(200);
        $response->assertViewIs('addStocks');
    }

    /**
     * Test Add Stocks
     * @dataProvider validStockDataProvider
     * SHK
     * @return void
     */
    public function test_add_new_stock($ISBN13, $bookName, $bookDesc, $bookAuthor, $date, $retail, $trade, $qty){
        // route to addstock function
        $response = $this->post(route('add-stock'), [
            'ISBN13' => $ISBN13,
            'bookName'=> $bookName,
            'bookDesc' => $bookDesc,
            'bookAuthor' => $bookAuthor,
            'publicationDate'=> $date,
            'retailPrice'=> $retail,
            'tradePrice'=> $trade,
            'qty'=> $qty
        ]);

        $this->assertDatabaseHas('stock', [
            'ISBN13' => $ISBN13,
            'bookName'=> $bookName,
            'bookDescription' => $bookDesc,
            'bookAuthor' => $bookAuthor,
            'publicationDate'=> $date,
            'retailPrice'=> $retail,
            'tradePrice'=> $trade,
            'qty'=> $qty
        ]);

        $response->assertRedirect('stocks');
    }

    public function validStockDataProvider()
    {
        return array(
            array("9999999999999", "test", "test", "Test", date('Y-m-d'), 20, 20, 0),
            array("9999999999998", "test", "test", "Test", date('Y-m-d', strtotime("-1 days")), 100, 20, 10),
            array("9999999999997", "test", "test", "Test", date('Y-m-d'), 20, 20, 10)
        );
    }

    /**
     * Test Add Stocks Failure
     * @dataProvider invalidStockDataProvider
     * SHK
     * @return void
     */
    public function test_add_new_stock_failure($ISBN13, $bookName, $bookDesc, $bookAuthor, $date, $retail, $trade, $qty){
        // route to addStock function
        $response = $this->from(route('addStocks'))->post(route('add-stock'), [
            'ISBN13' => $ISBN13,
            'bookName'=> $bookName,
            'bookDesc' => $bookDesc,
            'bookAuthor' => $bookAuthor,
            'publicationDate'=> $date,
            'retailPrice'=> $retail,
            'tradePrice'=> $trade,
            'qty'=> $qty
        ]);

        $response->assertRedirect(route('addStocks'));
    }

    public function invalidStockDataProvider()
    {
        return array(
            array("999999999999", "test", "test", "Test", date('Y-m-d'), 20, 20, 0), // ISBN13 12 char
            array("99999999999999", "test", "test", "Test", date('Y-m-d'), 20, 20, 0), // ISBN13 14 char
            array("9999999999999", "test", "test", "test", date('Y-m-d'), 20, 20, 10), // Author name regex invalid
            array("9999999999999", "test", "test", "Test", date('Y-m-d', strtotime("+1 days")), 20, 20, 10), // Publication Date Over
            array("9999999999999", "test", "test", "Test", date('Y-m-d'), 19, 20, 10), // Retail Below 20
            array("9999999999999", "test", "test", "Test", date('Y-m-d'), 101, 20, 10), // Retail over 100
            array("9999999999999", "test", "test", "Test", date('Y-m-d'), 20, 19, 10), // Trade Below 20
            array("9999999999999", "test", "test", "Test", date('Y-m-d'), 20, 101, 10), // Trade over 100
            array("9999999999999", "test", "test", "Test", date('Y-m-d'), 20, 20, -1), // Qty below 0
        );
    }

    /**
     * Test Add Existing Stocks, validation already tested above, no need re-test
     * SHK
     * @return void
     */
    public function test_add_existing_stock(){
        // seeder stock with qty 5
        $this->seed(StockTableSeeder::class);
        // route to addStock function
        $response = $this->from(route('addStocks'))->post(route('add-stock'), [
            'ISBN13' => 'testISBN12345',
            'bookName'=> 'testName',
            'bookDesc' => 'testDesc',
            'bookAuthor' => 'testAuthor',
            'publicationDate'=> date('Y-m-d'),
            'retailPrice'=> 20,
            'tradePrice'=> 20,
            'qty'=> 10
        ]);

        $this->assertDatabaseHas('stock', [
            'ISBN13' => 'testISBN12345',
            'bookName'=> 'testName',
            'bookDescription' => 'testDesc',
            'bookAuthor' => 'testAuthor',
            'publicationDate'=> date('Y-m-d'),
            'retailPrice'=> 20,
            'tradePrice'=> 20,
            'qty'=> 15 // 5 + 10
        ]);

        $response->assertRedirect('stocks');
    }

    /**
     * Test Get Stock on Success
     * SHK
     * @return void
     */
    public function test_get_stock(){
        // seed Stock Table
        $this->seed(StockTableSeeder::class);

        // route to getStock function
        $response = $this->post('/addStocks/get-stock', [
            'ISBN13' => 'testISBN12345',
        ]);
        
        $response->assertStatus(200); 
        $this->assertTrue($response['ISBN13'] != 1);
    }

    /**
     * Test Get Stock on Fail
     * SHK
     * @return void
     */
    public function test_get_stock_fail(){

        // route to getStock function
        $response = $this->post('/addStocks/get-stock', [
            'ISBN13' => 'failISBNtest1'
        ]);

        $response->assertStatus(200); 
    }
}
