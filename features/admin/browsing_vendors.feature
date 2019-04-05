@managing_vendors
Feature: Browsing vendors
    In order to show different brands
    As an Administrator
    I want to be able to browse vendors

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And the store has 5 vendors

    @ui
    Scenario: Browsing defined vendors
        When I want to browse vendors
        Then I should see 5 vendors in the list
