# features/login.feature

Feature: Admin Login
    In order to access Admin Priviliges
    As an Admin
    Admin needs to be able to login into Admin Account

Background:
	Given the Admin is already registered to the website
	
Scenario: Admin Login
	Given the admin is on the login page
	When the admin inputs the correct email and password
	And the admin clicks on the Login button
	Then the admin should be authenticated and login
	And the admin is redirected to the home page
	