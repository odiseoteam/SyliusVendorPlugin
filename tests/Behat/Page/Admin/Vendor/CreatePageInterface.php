<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillName(string $name): void;

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillSlug(string $slug): void;

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillDescription(string $description): void;

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillEmail(string $email): void;

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function uploadFile(string $file): void;
}
