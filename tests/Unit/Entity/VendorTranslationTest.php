<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Entity;

use Odiseo\SyliusVendorPlugin\Entity\VendorTranslation;
use Odiseo\SyliusVendorPlugin\Entity\VendorTranslationInterface;
use PHPUnit\Framework\TestCase;

final class VendorTranslationTest extends TestCase
{
    private VendorTranslation $vendorTranslation;

    protected function setUp(): void
    {
        $this->vendorTranslation = new VendorTranslation();
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorTranslationInterface::class, $this->vendorTranslation);
    }

    public function testItHasNoIdByDefault(): void
    {
        $this->assertNull($this->vendorTranslation->getId());
    }

    public function testItHasNoDescriptionByDefault(): void
    {
        $this->assertNull($this->vendorTranslation->getDescription());
    }

    public function testItAllowsToSetAndGetDescription(): void
    {
        $this->vendorTranslation->setDescription('Test description');
        $this->assertEquals('Test description', $this->vendorTranslation->getDescription());
    }

    public function testItHasCreatedAtSetOnConstruction(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->vendorTranslation->getCreatedAt());
    }

    public function testItIsTimestampable(): void
    {
        $now = new \DateTime();

        $this->vendorTranslation->setUpdatedAt($now);
        $this->assertEquals($now, $this->vendorTranslation->getUpdatedAt());
    }

    public function testItInheritsLocaleFromAbstractTranslation(): void
    {
        $this->vendorTranslation->setLocale('en_US');
        $this->assertEquals('en_US', $this->vendorTranslation->getLocale());
    }
}
