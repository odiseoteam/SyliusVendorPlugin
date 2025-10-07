<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Event\VendorFormMenuBuilderEvent;
use PHPUnit\Framework\TestCase;

final class VendorFormMenuBuilderEventTest extends TestCase
{
    public function testItIsInitializable(): void
    {
        $factory = $this->createMock(FactoryInterface::class);
        $menu = $this->createMock(ItemInterface::class);
        $vendor = new Vendor();

        $event = new VendorFormMenuBuilderEvent($factory, $menu, $vendor);

        $this->assertInstanceOf(VendorFormMenuBuilderEvent::class, $event);
    }

    public function testItReturnsFactory(): void
    {
        $factory = $this->createMock(FactoryInterface::class);
        $menu = $this->createMock(ItemInterface::class);
        $vendor = new Vendor();

        $event = new VendorFormMenuBuilderEvent($factory, $menu, $vendor);

        $this->assertSame($factory, $event->getFactory());
    }

    public function testItReturnsMenu(): void
    {
        $factory = $this->createMock(FactoryInterface::class);
        $menu = $this->createMock(ItemInterface::class);
        $vendor = new Vendor();

        $event = new VendorFormMenuBuilderEvent($factory, $menu, $vendor);

        $this->assertSame($menu, $event->getMenu());
    }

    public function testItReturnsVendor(): void
    {
        $factory = $this->createMock(FactoryInterface::class);
        $menu = $this->createMock(ItemInterface::class);
        $vendor = new Vendor();

        $event = new VendorFormMenuBuilderEvent($factory, $menu, $vendor);

        $this->assertSame($vendor, $event->getVendor());
    }
}
