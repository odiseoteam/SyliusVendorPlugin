<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Entity;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Entity\VendorsTrait;
use PHPUnit\Framework\TestCase;

final class VendorsTraitTest extends TestCase
{
    private object $entity;

    protected function setUp(): void
    {
        $this->entity = new class() {
            use VendorsTrait;
        };
    }

    public function testItInitializesVendorsCollection(): void
    {
        $this->assertCount(0, $this->entity->getVendors());
    }

    public function testItManagesVendors(): void
    {
        $vendor = new Vendor();

        $this->assertFalse($this->entity->hasVendor($vendor));

        $this->entity->addVendor($vendor);
        $this->assertTrue($this->entity->hasVendor($vendor));
        $this->assertCount(1, $this->entity->getVendors());

        $this->entity->removeVendor($vendor);
        $this->assertFalse($this->entity->hasVendor($vendor));
        $this->assertCount(0, $this->entity->getVendors());
    }
}
