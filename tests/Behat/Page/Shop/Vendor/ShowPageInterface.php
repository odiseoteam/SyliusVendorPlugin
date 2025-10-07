<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Shop\Vendor;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ShowPageInterface extends SymfonyPageInterface
{
    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function hasName(string $name): bool;
}
