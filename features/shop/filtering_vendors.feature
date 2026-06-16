@shop_vendors
Feature: Filtering displayed vendors
    In order to only browse available brands
    As a Customer
    I want disabled vendors to be hidden from the store

    Background:
        Given the store operates on a single channel in "United States"

    @ui
    Scenario: Not displaying disabled vendors
        Given there is an existing vendor with "Active" name
        And there is a disabled vendor with "Hidden" name
        When I want to list vendors
        Then I should see 1 vendors on the page
