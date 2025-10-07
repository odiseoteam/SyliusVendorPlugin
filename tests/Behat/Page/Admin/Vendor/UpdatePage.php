<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorTrait;
use Webmozart\Assert\Assert;

final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ContainsErrorTrait;

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    public function fillSlug(string $slug): void
    {
        $this->getDocument()->fillField('Slug', $slug);
    }

    public function fillDescription(string $description): void
    {
        $this->getDocument()->fillField('Description', $description);
    }

    public function fillEmail(string $email): void
    {
        $this->getDocument()->fillField('Email', $email);
    }

    public function uploadFile(string $file): void
    {
        $path = __DIR__ . '/../../../Resources/images/' . $file;
        Assert::fileExists($path);
        $realPath = realpath($path);
        Assert::string($realPath, sprintf('Could not resolve real path for %s', $path));
        $this->getDocument()->attachFileToField('Logo', $realPath);
    }
}
