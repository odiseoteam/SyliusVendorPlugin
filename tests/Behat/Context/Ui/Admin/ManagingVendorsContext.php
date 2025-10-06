<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor\CreatePageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor\IndexPageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingVendorsContext implements Context
{
    public function __construct(
        private CurrentPageResolverInterface $currentPageResolver,
        private IndexPageInterface $indexPage,
        private CreatePageInterface $createPage,
        private UpdatePageInterface $updatePage,
    ) {
    }

    /**
     * @When I go to the vendors page
     *
     * @throws UnexpectedPageException
     */
    public function iGoToTheVendorsPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Given I want to add a new vendor
     *
     * @throws UnexpectedPageException
     */
    public function iWantToAddNewVendor(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I fill the name with :vendorName
     * @When I rename the name with :vendorName
     *
     * @throws ElementNotFoundException
     */
    public function iFillTheNameWith(string $vendorName): void
    {
        $this->createPage->fillName($vendorName);
    }

    /**
     * @When I fill the slug with :vendorSlug
     * @When I rename the slug with :vendorSlug
     *
     * @throws ElementNotFoundException
     */
    public function iFillTheSlugWith(string $vendorSlug): void
    {
        $this->createPage->fillSlug($vendorSlug);
    }

    /**
     * @When I fill the description with :vendorDescription
     * @When I change the description with :vendorDescription
     *
     * @throws ElementNotFoundException
     */
    public function iFillTheDescriptionWith(string $vendorDescription): void
    {
        $this->createPage->fillDescription($vendorDescription);
    }

    /**
     * @When I fill the email with :vendorEmail
     * @When I change the email with :vendorEmail
     *
     * @throws ElementNotFoundException
     */
    public function iFillTheEmailWith(string $vendorEmail): void
    {
        $this->createPage->fillEmail($vendorEmail);
    }

    /**
     * @When I upload the :file image
     *
     * @throws ElementNotFoundException
     */
    public function iUploadTheImage(string $vendorImage): void
    {
        $this->resolveCurrentPage()->uploadFile($vendorImage);
    }

    /**
     * @When I add it
     *
     * @throws ElementNotFoundException
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @Given /^I want to modify the (vendor "([^"]+)")/
     *
     * @throws UnexpectedPageException
     */
    public function iWantToModifyVendor(VendorInterface $vendor): void
    {
        $this->updatePage->open(['id' => $vendor->getId()]);
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges(): void
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When I want to browse vendors
     *
     * @throws UnexpectedPageException
     */
    public function iWantToBrowseVendors(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :quantity vendors in the list
     */
    public function iShouldSeeVendorsInTheList(int $quantity = 1): void
    {
        Assert::same($this->indexPage->countItems(), (int) $quantity);
    }

    /**
     * @When I delete the vendor :name
     */
    public function iDeleteTheVendor(string $name): void
    {
        $this->indexPage->deleteVendor($name);
    }

    /**
     * @Then /^the (vendor "([^"]+)") should appear in the admin/
     *
     * @throws UnexpectedPageException
     */
    public function vendorShouldAppearInTheAdmin(VendorInterface $vendor): void
    {
        $this->indexPage->open();

        //Webmozart assert library.
        Assert::true(
            $this->indexPage->isSingleResourceOnPage(['name' => $vendor->getName()]),
            sprintf('Vendor %s should exist but it does not', $vendor->getName()),
        );
    }

    /**
     * @Then I should be notified that the form contains invalid fields
     */
    public function iShouldBeNotifiedThatTheFormContainsInvalidFields(): void
    {
        Assert::true(
            $this->resolveCurrentPage()->containsError(),
            sprintf('The form should be notified you that the form contains invalid field but it does not'),
        );
    }

    private function resolveCurrentPage(): CreatePageInterface|UpdatePageInterface
    {
        $page = $this->currentPageResolver->getCurrentPageWithForm([
            $this->createPage,
            $this->updatePage,
        ]);

        if (!$page instanceof CreatePageInterface && !$page instanceof UpdatePageInterface) {
            throw new \RuntimeException('Resolved page is not a create or update vendor page.');
        }

        return $page;
    }
}
