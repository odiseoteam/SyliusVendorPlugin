<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Entity;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Entity\VendorTrait;
use PHPUnit\Framework\TestCase;

final class VendorTraitTest extends TestCase
{
    private object $entity;

    protected function setUp(): void
    {
        $this->entity = new class() {
            use VendorTrait;
        };
    }

    public function testItHasNoVendorByDefault(): void
    {
        $this->assertNull($this->entity->getVendor());
    }

    public function testItAllowsToSetAndGetVendor(): void
    {
        $vendor = new Vendor();

        $this->entity->setVendor($vendor);
        $this->assertSame($vendor, $this->entity->getVendor());
    }

    public function testItAllowsToSetVendorToNull(): void
    {
        $vendor = new Vendor();
        $this->entity->setVendor($vendor);

        $this->entity->setVendor(null);
        $this->assertNull($this->entity->getVendor());
    }
}
