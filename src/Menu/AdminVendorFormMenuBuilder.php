<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Event\VendorFormMenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AdminVendorFormMenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function createMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if (!array_key_exists('vendor', $options) || !$options['vendor'] instanceof VendorInterface) {
            return $menu;
        }

        $menu
            ->addChild('details')
            ->setAttribute('template', '@OdiseoSyliusVendorPlugin/Admin/Vendor/Tab/_details.html.twig')
            ->setLabel('sylius.ui.details')
            ->setCurrent(true)
        ;

        $menu
            ->addChild('profile')
            ->setAttribute('template', '@OdiseoSyliusVendorPlugin/Admin/Vendor/Tab/_profile.html.twig')
            ->setLabel('odiseo_vendor.ui.profile')
        ;

        $menu
            ->addChild('media')
            ->setAttribute('template', '@OdiseoSyliusVendorPlugin/Admin/Vendor/Tab/_media.html.twig')
            ->setLabel('sylius.ui.media')
        ;

        $this->eventDispatcher->dispatch(
            new VendorFormMenuBuilderEvent($this->factory, $menu, $options['vendor']),
        );

        return $menu;
    }
}
