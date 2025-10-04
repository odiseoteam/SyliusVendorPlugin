<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Uploader;

use Gaufrette\FilesystemInterface;
use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

final class VendorLogoUploaderTest extends TestCase
{
    private VendorLogoUploader $uploader;

    private FilesystemInterface $filesystem;

    protected function setUp(): void
    {
        $this->filesystem = $this->createMock(FilesystemInterface::class);
        $this->uploader = new VendorLogoUploader($this->filesystem);
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorLogoUploader::class, $this->uploader);
    }

    public function testItDoesNothingWhenNoLogoFile(): void
    {
        $vendor = new Vendor();

        $this->filesystem->expects($this->never())
            ->method('write');

        $this->uploader->upload($vendor);
        $this->assertNull($vendor->getLogoName());
    }

    public function testItCanUploadLogo(): void
    {
        // Create a real temporary file for testing
        $tmpFile = tempnam(sys_get_temp_dir(), 'test_logo');
        file_put_contents($tmpFile, 'test content');

        $vendor = new Vendor();
        $file = new File($tmpFile);
        $vendor->setLogoFile($file);

        // Mock filesystem to simulate successful operations
        $this->filesystem->expects($this->any())
            ->method('has')
            ->willReturn(false);

        $this->filesystem->expects($this->once())
            ->method('write')
            ->with($this->isType('string'), 'test content', true);

        $this->uploader->upload($vendor);

        // Verify that a logo name was set
        $this->assertNotNull($vendor->getLogoName());

        // Clean up
        unlink($tmpFile);
    }
}
