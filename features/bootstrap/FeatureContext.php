<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Tests\CreateApplication;
use Tests\TestCase;
use database\seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends TestCase implements Context
{
    use DatabaseTransactions;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        putenv("APP_ENV=testing");
        parent::__construct();
        $this->setUp();
        $this->withExceptionHandling();
        $this->post(route('register-user'), [
            'userName' => 'SIMHK',
            'userEmail' => 'SIMHK@gmail.com',
            'userPassword' => 'PotatoSim@10',
            'privilige' => 2
        ]);
    }

    /**
     * @Given the Admin is already registered to the website
     */
    public function theAdminIsAlreadyRegisteredToTheWebsite()
    {
        //$this->seed(UsersTableSeeder::class);
        // check if registered
        $this->assertDatabaseHas('users', [
            'username' => 'SIMHK',
            'userEmail' => 'SIMHK@gmail.com',
            'userPrivilige' => 2
        ]);
    }

    /**
     * @Given the admin is on the login page
     */
    public function theAdminIsOnTheLoginPage()
    {
        // check is Login View
        $this->response = $this->get(route('LoginUser'));
        $this->response->assertViewIs('auth.login');
    }

    /**
     * @When the admin inputs the correct email and password
     */
    public function theAdminInputsTheCorrectEmailAndPassword()
    {
        $this->response = $this->post(route('login-user'), [
            'userEmail' => 'SIMHK@gmail.com',
            'userPassword' => 'PotatoSim@10'
        ]);
        // no assert here
        return true;
    }

    /**
     * @When the admin clicks on the Login button
     */
    public function theAdminClicksOnTheLoginButton()
    {
        return true;
    }

    /**
     * @Then the admin should be authenticated and login
     */
    public function theAdminShouldBeAuthenticatedAndLogin()
    {
        return true;
    }

    /**
     * @Then the admin is redirected to the home page
     */
    public function theAdminIsRedirectedToTheHomePage()
    {
        $this->response->assertRedirect('/home');
    }


    // ADD STOCK--------------------------
    /**
     * @Given the Admin is already Logged In
     */
    public function theAdminIsAlreadyLoggedIn()
    {
        $this->response = $this->response = $this->post(route('login-user'), [
            'userEmail' => 'SIMHK@gmail.com',
            'userPassword' => 'PotatoSim@10'
        ]);
        $this->response->assertRedirect('/home');
    }

    /**
     * @Given the admin is on the Add Stock Page
     */
    public function theAdminIsOnTheAddStockPage()
    {
        $this->response = $this->get(route('addStocks'));
        $this->response->assertViewIs('addStocks');
    }

    /**
     * @When the admin Fills In the Stock Details Form
     */
    public function theAdminFillsInTheStockDetailsForm()
    {
        $this->ISBN13 = "TestISBN12345";
        $this->bookName = "TestName";
        $this->bookDesc = "TestDesc";
        $this->bookAuthor = "TestAuthor";
        $this->publicationDate = date('Y-m-d');
        $this->retailPrice = 20;
        $this->tradePrice = 30;
        $this->qty = 1;
    }

    /**
     * @When the admin clicks on the Add Stock Button
     */
    public function theAdminClicksOnTheAddStockButton()
    {
        $this->response = $this->post(route('add-stock'), [
            'ISBN13' => $this->ISBN13,
            'bookName' => $this->bookName,
            'bookDesc' => $this->bookDesc,
            'bookAuthor' => $this->bookAuthor,
            'publicationDate'=> $this->publicationDate,
            'retailPrice'=> $this->retailPrice,
            'tradePrice'=> $this->tradePrice,
            'qty'=> $this->qty
        ]);
    }

    /**
     * @Then stock should be added
     */
    public function stockShouldBeAdded()
    {
        $this->assertDatabaseHas('stock', [
            'ISBN13' => $this->ISBN13,
            'bookName'=> $this->bookName,
            'bookDescription' => $this->bookDesc,
            'bookAuthor' => $this->bookAuthor,
            'publicationDate'=> $this->publicationDate,
            'retailPrice'=> $this->retailPrice,
            'tradePrice'=> $this->tradePrice,
            'qty'=> $this->qty
        ]);
    }

    /**
     * @Then the admin is redirected to the Stocks Page
     */
    public function theAdminIsRedirectedToTheStocksPage()
    {
        $this->response->assertRedirect('stocks');
    }

}
