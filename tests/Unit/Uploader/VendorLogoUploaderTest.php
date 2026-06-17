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
        $this->assertNull($vendor->getLogoPath());
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

        // Verify that a logo path was set
        $this->assertNotNull($vendor->getLogoPath());

        // Clean up
        unlink($tmpFile);
    }

    public function testItRemovesThePreviousLogoBeforeUploadingANewOne(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'test_logo');
        file_put_contents($tmpFile, 'new content');

        $vendor = new Vendor();
        $vendor->setLogoPath('old-logo.png');
        $vendor->setLogoFile(new File($tmpFile));

        $this->filesystem->method('has')
            ->willReturnCallback(static fn (string $path): bool => 'old-logo.png' === $path);

        $this->filesystem->expects($this->once())
            ->method('delete')
            ->with('old-logo.png')
            ->willReturn(true);

        $this->filesystem->expects($this->once())
            ->method('write');

        $this->uploader->upload($vendor);

        $this->assertNotNull($vendor->getLogoPath());
        $this->assertNotSame('old-logo.png', $vendor->getLogoPath());

        unlink($tmpFile);
    }

    public function testItRemovesAnExistingFile(): void
    {
        $this->filesystem->method('has')
            ->with('logo.png')
            ->willReturn(true);

        $this->filesystem->expects($this->once())
            ->method('delete')
            ->with('logo.png')
            ->willReturn(true);

        $this->assertTrue($this->uploader->remove('logo.png'));
    }

    public function testItDoesNotRemoveAMissingFile(): void
    {
        $this->filesystem->method('has')
            ->with('logo.png')
            ->willReturn(false);

        $this->filesystem->expects($this->never())
            ->method('delete');

        $this->assertFalse($this->uploader->remove('logo.png'));
    }
}
