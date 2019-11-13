<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor\CreatePageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor\IndexPageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingVendorsContext implements Context
{
    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var IndexPageInterface */
    private $indexPage;

    /** @var CreatePageInterface */
    private $createPage;

    /** @var UpdatePageInterface */
    private $updatePage;

    public function __construct(
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage
    ) {
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
    }

    /**
     * @When I go to the vendors page
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function iGoToTheVendorsPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Given I want to add a new vendor
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function iWantToAddNewVendor(): void
    {
        $this->createPage->open(); // This method will send request.
    }

    /**
     * @When I fill the name with :vendorName
     * @When I rename the name with :vendorName
     * @param string $vendorName
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheNameWith(string $vendorName): void
    {
        $this->createPage->fillName($vendorName);
    }

    /**
     * @When I fill the slug with :vendorSlug
     * @When I rename the slug with :vendorSlug
     * @param string $vendorSlug
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheSlugWith(string $vendorSlug): void
    {
        $this->createPage->fillSlug($vendorSlug);
    }

    /**
     * @When I fill the description with :vendorDescription
     * @When I change the description with :vendorDescription
     * @param string $vendorDescription
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheDescriptionWith(string $vendorDescription): void
    {
        $this->createPage->fillDescription($vendorDescription);
    }

    /**
     * @When I fill the email with :vendorEmail
     * @When I change the email with :vendorEmail
     * @param string $vendorEmail
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheEmailWith(string $vendorEmail): void
    {
        $this->createPage->fillEmail($vendorEmail);
    }

    /**
     * @When I upload the :file image
     * @param string $vendorImage
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iUploadTheImage(string $vendorImage): void
    {
        $this->resolveCurrentPage()->uploadFile($vendorImage);
    }

    /**
     * @When I add it
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @Given /^I want to modify the (vendor "([^"]+)")/
     * @param VendorInterface $vendor
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
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
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function iWantToBrowseVendors(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :quantity vendors in the list
     * @param $quantity
     */
    public function iShouldSeeVendorsInTheList(int $quantity = 1): void
    {
        Assert::same($this->indexPage->countItems(), (int) $quantity);
    }

    /**
     * @When I delete the vendor :name
     * @param string $name
     */
    public function iDeleteTheVendor(string $name): void
    {
        $this->indexPage->deleteVendor($name);
    }

    /**
     * @Then /^the (vendor "([^"]+)") should appear in the admin/
     * @param VendorInterface $vendor
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function vendorShouldAppearInTheAdmin(VendorInterface $vendor): void
    {
        $this->indexPage->open();

        //Webmozart assert library.
        Assert::true(
            $this->indexPage->isSingleResourceOnPage(['name' => $vendor->getName()]),
            sprintf('Vendor %s should exist but it does not', $vendor->getName())
        );
    }

    /**
     * @Then I should be notified that the form contains invalid fields
     */
    public function iShouldBeNotifiedThatTheFormContainsInvalidFields(): void
    {
        Assert::true($this->resolveCurrentPage()->containsError(),
            sprintf('The form should be notified you that the form contains invalid field but it does not')
        );
    }

    /**
     * @Then I should be notified that there is already an existing vendor with provided slug
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingVendorWithSlug(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing vendor with this slug.',
            false
        ));
    }

    /**
     * @return IndexPageInterface|CreatePageInterface|UpdatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->indexPage,
            $this->createPage,
            $this->updatePage
        ]);
    }
}
