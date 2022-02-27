@shop_vendors
Feature: Displaying brands
    In order to read store information
    As a Customer
    I want to display vendors

    Background:
        Given the store operates on a single channel in "United States"

    @ui
    Scenario: Displaying vendor
        Given there is an existing vendor with "Test" name
        And this vendor has "iPhone 8" and "iPhone X" products associated with it
        When I go to the "test" page
        Then I should see a page with "Test" name
