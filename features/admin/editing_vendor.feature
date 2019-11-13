@managing_vendors
Feature: Editing a vendor
    In order to change a brand
    As an Administrator
    I want to be able to edit a vendor

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And there is an existing vendor with "Test" name

    @ui
    Scenario: Renaming a vendor
        Given I want to modify the vendor "Test"
        When I rename the name with "Test Edited"
        And I save my changes
        Then I should be notified that it has been successfully edited
