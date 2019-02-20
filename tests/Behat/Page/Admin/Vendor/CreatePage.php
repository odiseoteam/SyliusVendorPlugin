<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorTrait;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    /**
     * @inheritdoc
     */
    public function fillName($name)
    {
        $this->getDocument()->fillField('Name', $name);
    }

    /**
     * @inheritdoc
     */
    public function fillDescription($description)
    {
        $this->getDocument()->fillField('Description', $description);
    }

    /**
     * @inheritdoc
     */
    public function fillEmail($email)
    {
        $this->getDocument()->fillField('Email', $email);
    }

    /**
     * {@inheritdoc}
     */
    public function uploadFile($file)
    {
        $path = __DIR__.'/../../../Resources/images/'.$file;
        Assert::fileExists($path);
        $this->getDocument()->attachFileToField('Logo', realpath($path));
    }
}
