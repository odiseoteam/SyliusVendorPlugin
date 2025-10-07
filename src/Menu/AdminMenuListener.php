<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        /** @var ItemInterface $item */
        $item = $menu->getChild('catalog');
        if (null == $item) {
            $item = $menu;
        }

        $item->addChild('vendors', ['route' => 'odiseo_vendor_admin_vendor_index'])
            ->setLabel('odiseo_vendor.menu.admin.vendors')
            ->setLabelAttribute('icon', 'trademark')
        ;
    }
}
