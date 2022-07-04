# features/addStock.feature

Feature: Add stock
    In order to add Stock
    As an Admin
    Admin needs to be able to Fill In Add Stock Form

Background:
	Given the Admin is already Logged In
	
Scenario: Add Stock
	Given the admin is on the Add Stock Page
	When the admin Fills In the Stock Details Form
	And the admin clicks on the Add Stock Button
	Then stock should be added
	And the admin is redirected to the Stocks Page
