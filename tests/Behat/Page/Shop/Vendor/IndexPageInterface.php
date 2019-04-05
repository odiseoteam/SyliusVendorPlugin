<?php

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Shop\Vendor;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface IndexPageInterface extends SymfonyPageInterface
{
    /**
     * @param string $pagesNumber
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function hasPagesNumber($pagesNumber);
}
