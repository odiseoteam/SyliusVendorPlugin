<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Entity;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Entity\VendorEmail;
use Odiseo\SyliusVendorPlugin\Entity\VendorEmailInterface;
use PHPUnit\Framework\TestCase;

final class VendorEmailTest extends TestCase
{
    private VendorEmail $vendorEmail;

    protected function setUp(): void
    {
        $this->vendorEmail = new VendorEmail();
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorEmailInterface::class, $this->vendorEmail);
    }

    public function testItHasNoIdByDefault(): void
    {
        $this->assertNull($this->vendorEmail->getId());
    }

    public function testItHasNoValueByDefault(): void
    {
        $this->assertNull($this->vendorEmail->getValue());
    }

    public function testItAllowsToSetAndGetValue(): void
    {
        $this->vendorEmail->setValue('test@example.com');
        $this->assertEquals('test@example.com', $this->vendorEmail->getValue());
    }

    public function testItHasCreatedAtSetOnConstruction(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->vendorEmail->getCreatedAt());
    }

    public function testItIsTimestampable(): void
    {
        $now = new \DateTime();

        $this->vendorEmail->setUpdatedAt($now);
        $this->assertEquals($now, $this->vendorEmail->getUpdatedAt());
    }

    public function testItCanBeAssociatedWithVendor(): void
    {
        $vendor = new Vendor();

        $this->vendorEmail->setVendor($vendor);
        $this->assertSame($vendor, $this->vendorEmail->getVendor());
    }
}
