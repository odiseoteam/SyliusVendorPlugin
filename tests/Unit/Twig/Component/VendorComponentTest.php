<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Twig\Component;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Twig\Component\VendorComponent;
use PHPUnit\Framework\TestCase;

final class VendorComponentTest extends TestCase
{
    private VendorComponent $component;

    protected function setUp(): void
    {
        $this->component = new VendorComponent();
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorComponent::class, $this->component);
    }

    public function testItHasNullVendorByDefault(): void
    {
        $this->assertNull($this->component->vendor);
    }

    public function testItCanSetVendor(): void
    {
        $vendor = new Vendor();
        $this->component->vendor = $vendor;

        $this->assertSame($vendor, $this->component->vendor);
    }
}
