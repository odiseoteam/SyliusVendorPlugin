@managing_vendors
Feature: Adding a new vendor
    In order to show different brands
    As an Administrator
    I want to add a new vendor to the admin

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui
    Scenario: Adding a new vendor
        Given I want to add a new vendor
        When I fill the name with "Test"
        And I fill the slug with "test"
        And I fill the description with "This is a test"
        And I fill the email with "test@odiseo.com.ar"
        And I upload the "logo_odiseo.png" image
        And I add it
        Then I should be notified that it has been successfully created
        And the vendor "Test" should appear in the admin

    @ui
    Scenario: Trying to add a new vendor with empty fields
        Given I want to add a new vendor
        When I fill the name with "Test"
        And I add it
        Then I should be notified that the form contains invalid fields

    @ui
    Scenario: Trying to add a vendor with existing slug
        Given there is an existing vendor with "Test" name
        And I want to add a new vendor
        When I fill the slug with "test"
        And I add it
        Then I should be notified that the form contains invalid fields
