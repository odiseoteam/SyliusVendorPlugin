<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $name
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillName(string $name): void;

    /**
     * @param string $slug
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillSlug(string $slug): void;

    /**
     * @param string $description
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillDescription(string $description): void;

    /**
     * @param string $email
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillEmail(string $email): void;

    /**
     * @param string $file
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function uploadFile(string $file): void;
}
