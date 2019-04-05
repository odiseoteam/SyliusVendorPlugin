@shop_vendors
Feature: Browsing brands
    In order to show different brands
    As a Customer
    I want to browse vendors

    Background:
        Given the store operates on a single channel in "United States"
        And the store has 10 vendors

    @ui
    Scenario: Browsing vendors
        When I want to list vendors
        Then I should see 10 vendors on the page
