<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorInterface;
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

    /**
     * @param CurrentPageResolverInterface $currentPageResolver
     * @param NotificationCheckerInterface $notificationChecker
     * @param IndexPageInterface $indexPage
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     */
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
     * @Given I want to add a new vendor
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function iWantToAddNewVendor()
    {
        $this->createPage->open(); // This method will send request.
    }

    /**
     * @When I fill the name with :vendorName
     * @param $vendorName
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheNameWith($vendorName)
    {
        $this->createPage->fillName($vendorName);
    }

    /**
     * @When I fill the description with :vendorDescription
     * @When I change the description with :vendorDescription
     * @param $vendorDescription
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheDescriptionWith($vendorDescription)
    {
        $this->createPage->fillDescription($vendorDescription);
    }

    /**
     * @When I fill the email with :vendorEmail
     * @When I change the email with :vendorEmail
     * @param $vendorEmail
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheEmailWith($vendorEmail)
    {
        $this->createPage->fillEmail($vendorEmail);
    }

    /**
     * @When I upload the :file image
     * @param $vendorImage
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iUploadTheImage($vendorImage)
    {
        $this->resolveCurrentPage()->uploadFile($vendorImage);
    }

    /**
     * @When I add it
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @Given /^I want to modify the (vendor "([^"]+)")/
     * @param VendorInterface $vendor
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function iWantToModifyVendor(VendorInterface $vendor)
    {
        $this->updatePage->open(['id' => $vendor->getId()]);
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @Then /^the (vendor "([^"]+)") should appear in the admin/
     * @param VendorInterface $vendor
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function vendorShouldAppearInTheAdmin(VendorInterface $vendor)
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
     * @Then I should be notified that there is already an existing vendor with provided name
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingVendorWithCode(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing vendor with this code.',
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
