<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        /** @var ItemInterface $item */
        $item = $menu->getChild('catalog');
        if (null == $item) {
            $item = $menu;
        }

        $item->addChild('vendors', ['route' => 'odiseo_sylius_vendor_plugin_admin_vendor_index'])
            ->setLabel('odiseo_sylius_vendor_plugin.ui.vendors')
            ->setLabelAttribute('icon', 'trademark')
        ;
    }
}
