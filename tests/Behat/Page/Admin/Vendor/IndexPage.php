<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;

final class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    /**
     * @inheritdoc
     */
    public function deleteVendor(string $name): void
    {
        $this->deleteResourceOnPage(['name' => $name]);
    }
}
