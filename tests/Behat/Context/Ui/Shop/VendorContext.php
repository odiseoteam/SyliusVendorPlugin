<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Shop\Vendor\IndexPageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Shop\Vendor\ShowPageInterface;
use Webmozart\Assert\Assert;

final class VendorContext implements Context
{
    /** @var IndexPageInterface */
    private $indexPage;

    /** @var ShowPageInterface */
    private $showPage;

    public function __construct(
        IndexPageInterface $indexPage,
        ShowPageInterface $showPage
    ) {
        $this->indexPage = $indexPage;
        $this->showPage = $showPage;
    }

    /**
     * @When I want to list vendors
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function iWantToListVendors(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :pagesNumber vendors on the page
     * @param int $pagesNumber
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iShouldSeeVendorsOnThePage(int $pagesNumber): void
    {
        Assert::true($this->indexPage->hasPagesNumber($pagesNumber));
    }

    /**
     * @When I go to the :slug page
     * @param string $slug
     * @throws \FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException
     */
    public function iGoToThePage(string $slug): void
    {
        $this->showPage->open(['slug' => $slug]);
    }

    /**
     * @Then I should see a page with :name name
     * @param string $name
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iShouldSeeAPageWithName(string $name): void
    {
        Assert::true($this->showPage->hasName($name));
    }
}
