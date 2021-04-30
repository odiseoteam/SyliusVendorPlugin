<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Shop\Vendor;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage implements ShowPageInterface
{
    /**
     * @inheritdoc
     */
    public function getRouteName(): string
    {
        return 'odiseo_sylius_vendor_plugin_shop_vendor_product_index';
    }

    /**
     * @inheritdoc
     */
    public function hasName(string $name): bool
    {
        return $name === $this->getElement('name')->getText();
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '.odiseo-vendor-name'
        ]);
    }
}
