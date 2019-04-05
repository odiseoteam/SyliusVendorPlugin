<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Shop\Vendor;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class ShowPage extends SymfonyPage implements ShowPageInterface
{
    public function getRouteName(): string
    {
        return 'odiseo_sylius_vendor_shop_vendor_show';
    }

    /**
     * @inheritdoc
     */
    public function hasName($name)
    {
        return $name === $this->getElement('name')->getText();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '.odiseo-vendor-name'
        ]);
    }
}
