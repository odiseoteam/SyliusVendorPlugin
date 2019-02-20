<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour\ContainsErrorTrait;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ContainsErrorTrait;

    /**
     * @inheritdoc
     */
    public function fillName($name)
    {
        $this->getDocument()->fillField('Name', $name);
    }
}
