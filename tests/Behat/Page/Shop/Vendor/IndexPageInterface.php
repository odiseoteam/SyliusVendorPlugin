<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Shop\Vendor;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface IndexPageInterface extends SymfonyPageInterface
{
    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function hasPagesNumber(int $pagesNumber): bool;
}
