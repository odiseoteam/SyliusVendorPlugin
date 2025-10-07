<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Entity;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Entity\VendorEmail;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Channel\Model\Channel;
use Sylius\Component\Product\Model\Product;
use Symfony\Component\HttpFoundation\File\File;

final class VendorTest extends TestCase
{
    private VendorInterface $vendor;

    protected function setUp(): void
    {
        $this->vendor = new Vendor();
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorInterface::class, $this->vendor);
    }

    public function testItHasNoIdByDefault(): void
    {
        $this->assertNull($this->vendor->getId());
    }

    public function testItHasNoNameByDefault(): void
    {
        $this->assertNull($this->vendor->getName());
    }

    public function testItAllowsAccessViaProperties(): void
    {
        $this->vendor->setName('Test Vendor');
        $this->assertEquals('Test Vendor', $this->vendor->getName());

        $this->vendor->setEmail('test@vendor.com');
        $this->assertEquals('test@vendor.com', $this->vendor->getEmail());

        $this->vendor->setSlug('test-vendor');
        $this->assertEquals('test-vendor', $this->vendor->getSlug());

        $this->vendor->setPosition(5);
        $this->assertEquals(5, $this->vendor->getPosition());
    }

    public function testItSupportsLogoFile(): void
    {
        $file = $this->createMock(File::class);
        $this->vendor->setLogoFile($file);
        $this->assertSame($file, $this->vendor->getLogoFile());

        $this->vendor->setLogoName('logo.png');
        $this->assertEquals('logo.png', $this->vendor->getLogoName());
    }

    public function testItManagesChannels(): void
    {
        $channel = new Channel();

        $this->assertCount(0, $this->vendor->getChannels());
        $this->assertFalse($this->vendor->hasChannel($channel));

        $this->vendor->addChannel($channel);
        $this->assertCount(1, $this->vendor->getChannels());
        $this->assertTrue($this->vendor->hasChannel($channel));

        $this->vendor->removeChannel($channel);
        $this->assertCount(0, $this->vendor->getChannels());
        $this->assertFalse($this->vendor->hasChannel($channel));
    }

    public function testItManagesProducts(): void
    {
        $product = new Product();

        $this->assertCount(0, $this->vendor->getProducts());
        $this->assertFalse($this->vendor->hasProduct($product));

        $this->vendor->addProduct($product);
        $this->assertCount(1, $this->vendor->getProducts());
        $this->assertTrue($this->vendor->hasProduct($product));

        $this->vendor->removeProduct($product);
        $this->assertCount(0, $this->vendor->getProducts());
        $this->assertFalse($this->vendor->hasProduct($product));
    }

    public function testItManagesExtraEmails(): void
    {
        $email = new VendorEmail();

        $this->assertCount(0, $this->vendor->getExtraEmails());
        $this->assertFalse($this->vendor->hasExtraEmail($email));

        $this->vendor->addExtraEmail($email);
        $this->assertCount(1, $this->vendor->getExtraEmails());
        $this->assertTrue($this->vendor->hasExtraEmail($email));

        $this->vendor->removeExtraEmail($email);
        $this->assertCount(0, $this->vendor->getExtraEmails());
        $this->assertFalse($this->vendor->hasExtraEmail($email));
    }

    public function testItIsToggleable(): void
    {
        $this->assertTrue($this->vendor->isEnabled());

        $this->vendor->disable();
        $this->assertFalse($this->vendor->isEnabled());

        $this->vendor->enable();
        $this->assertTrue($this->vendor->isEnabled());
    }

    public function testItIsTimestampable(): void
    {
        $now = new \DateTime();

        $this->vendor->setCreatedAt($now);
        $this->assertEquals($now, $this->vendor->getCreatedAt());

        $this->vendor->setUpdatedAt($now);
        $this->assertEquals($now, $this->vendor->getUpdatedAt());
    }

    public function testItHasStringRepresentation(): void
    {
        $this->vendor->setName('Test Vendor');
        $this->assertEquals('Test Vendor', $this->vendor->getName());
    }
}
