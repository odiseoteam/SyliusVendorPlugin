<?php

namespace Odiseo\SyliusVendorPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        //Add new ones
        $this->addVendorsSubMenu($menu->getChild('catalog'));
    }

    /**
     * @param ItemInterface $menu
     */
    private function addVendorsSubMenu(ItemInterface $menu): void
    {
        $menu
            ->addChild('vendors', ['route' => 'odiseo_sylius_vendor_admin_vendor_index'])
            ->setLabel('odiseo_sylius_vendor.ui.vendors')
            ->setLabelAttribute('icon', 'trademark')
        ;
    }
}