<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class VendorFormMenuBuilderEvent extends MenuBuilderEvent
{
    private VendorInterface $vendor;

    public function __construct(FactoryInterface $factory, ItemInterface $menu, VendorInterface $vendor)
    {
        parent::__construct($factory, $menu);

        $this->vendor = $vendor;
    }

    public function getVendor(): VendorInterface
    {
        return $this->vendor;
    }
}
