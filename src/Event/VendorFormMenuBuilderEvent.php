<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class VendorFormMenuBuilderEvent extends MenuBuilderEvent
{
    public function __construct(
        FactoryInterface $factory,
        ItemInterface $menu,
        private VendorInterface $vendor,
    ) {
        parent::__construct($factory, $menu);
    }

    public function getVendor(): VendorInterface
    {
        return $this->vendor;
    }
}
