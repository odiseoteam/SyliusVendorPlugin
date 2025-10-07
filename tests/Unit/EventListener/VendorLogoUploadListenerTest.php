<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\EventListener;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\EventListener\VendorLogoUploadListener;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\GenericEvent;

final class VendorLogoUploadListenerTest extends TestCase
{
    private VendorLogoUploadListener $listener;

    private VendorLogoUploaderInterface $uploader;

    protected function setUp(): void
    {
        $this->uploader = $this->createMock(VendorLogoUploaderInterface::class);
        $this->listener = new VendorLogoUploadListener($this->uploader);
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorLogoUploadListener::class, $this->listener);
    }

    public function testItUploadsLogoWhenEventTriggered(): void
    {
        $vendor = new Vendor();
        $event = new GenericEvent($vendor);

        $this->uploader->expects($this->once())
            ->method('upload')
            ->with($vendor);

        $this->listener->uploadLogo($event);
    }

    public function testItThrowsExceptionForInvalidSubject(): void
    {
        $invalidSubject = new \stdClass();
        $event = new GenericEvent($invalidSubject);

        $this->expectException(\InvalidArgumentException::class);

        $this->listener->uploadLogo($event);
    }
}
