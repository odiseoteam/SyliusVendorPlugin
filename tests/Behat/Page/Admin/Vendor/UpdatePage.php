<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorTrait;

final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ContainsErrorTrait;

    /**
     * @inheritdoc
     */
    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }
}
