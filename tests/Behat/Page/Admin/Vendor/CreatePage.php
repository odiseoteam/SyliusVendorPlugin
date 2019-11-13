<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorTrait;
use Webmozart\Assert\Assert;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    /**
     * @inheritdoc
     */
    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    /**
     * @inheritdoc
     */
    public function fillSlug(string $slug): void
    {
        $this->getDocument()->fillField('Slug', $slug);
    }

    /**
     * @inheritdoc
     */
    public function fillDescription(string $description): void
    {
        $this->getDocument()->fillField('Description', $description);
    }

    /**
     * @inheritdoc
     */
    public function fillEmail(string $email): void
    {
        $this->getDocument()->fillField('Email', $email);
    }

    /**
     * {@inheritdoc}
     */
    public function uploadFile(string $file): void
    {
        $path = __DIR__.'/../../../Resources/images/'.$file;
        Assert::fileExists($path);
        $this->getDocument()->attachFileToField('Logo', realpath($path));
    }
}
