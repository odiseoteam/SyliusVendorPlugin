<?php

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $code
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillName($code);

    /**
     * @param string $description
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillDescription($description);

    /**
     * @param string $email
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillEmail($email);

    /**
     * @param string $file
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function uploadFile($file);
}
