<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Menu;

use Knp\Menu\ItemInterface;
use Odiseo\SyliusVendorPlugin\Menu\AdminMenuListener;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListenerTest extends TestCase
{
    private AdminMenuListener $listener;

    protected function setUp(): void
    {
        $this->listener = new AdminMenuListener();
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(AdminMenuListener::class, $this->listener);
    }

    public function testItAddsMenuItemToCatalogChild(): void
    {
        $factory = $this->createMock(\Knp\Menu\FactoryInterface::class);
        $menu = $this->createMock(ItemInterface::class);
        $catalogItem = $this->createMock(ItemInterface::class);
        $vendorsItem = $this->createMock(ItemInterface::class);
        $event = new MenuBuilderEvent($factory, $menu);

        $menu->expects($this->once())
            ->method('getChild')
            ->with('catalog')
            ->willReturn($catalogItem);

        $catalogItem->expects($this->once())
            ->method('addChild')
            ->with('vendors', ['route' => 'odiseo_vendor_admin_vendor_index'])
            ->willReturn($vendorsItem);

        $vendorsItem->expects($this->once())
            ->method('setLabel')
            ->with('odiseo_vendor.menu.admin.vendors')
            ->willReturnSelf();

        $vendorsItem->expects($this->once())
            ->method('setLabelAttribute')
            ->with('icon', 'trademark')
            ->willReturnSelf();

        $this->listener->addAdminMenuItems($event);
    }

    public function testItAddsMenuItemToMainMenuWhenCatalogNotFound(): void
    {
        $factory = $this->createMock(\Knp\Menu\FactoryInterface::class);
        $menu = $this->createMock(ItemInterface::class);
        $vendorsItem = $this->createMock(ItemInterface::class);
        $event = new MenuBuilderEvent($factory, $menu);

        $menu->expects($this->once())
            ->method('getChild')
            ->with('catalog')
            ->willReturn(null);

        $menu->expects($this->once())
            ->method('addChild')
            ->with('vendors', ['route' => 'odiseo_vendor_admin_vendor_index'])
            ->willReturn($vendorsItem);

        $vendorsItem->expects($this->once())
            ->method('setLabel')
            ->with('odiseo_vendor.menu.admin.vendors')
            ->willReturnSelf();

        $vendorsItem->expects($this->once())
            ->method('setLabelAttribute')
            ->with('icon', 'trademark')
            ->willReturnSelf();

        $this->listener->addAdminMenuItems($event);
    }
}
