<?php

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $name
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillName($name);
}
