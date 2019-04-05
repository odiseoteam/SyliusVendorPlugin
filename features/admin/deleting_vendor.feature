@managing_vendors
Feature: Deleting a vendor
    In order to delete a brand
    As an Administrator
    I want to be able to delete a vendor

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And there is an existing vendor with "Test" name

    @ui
    Scenario: Deleting a vendor
        When I go to the vendors page
        And I delete the vendor "Test"
        Then I should be notified that it has been successfully deleted
