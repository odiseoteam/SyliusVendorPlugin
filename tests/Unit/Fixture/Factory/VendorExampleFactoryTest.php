<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Fixture\Factory;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Fixture\Factory\VendorExampleFactory;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Locale\Model\Locale;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\FileLocatorInterface;

final class VendorExampleFactoryTest extends TestCase
{
    private FactoryInterface $vendorFactory;

    private VendorLogoUploaderInterface $vendorLogoUploader;

    private RepositoryInterface $localeRepository;

    private FileLocatorInterface $fileLocator;

    private VendorExampleFactory $factory;

    private string $logoPath;

    protected function setUp(): void
    {
        $this->vendorFactory = $this->createMock(FactoryInterface::class);
        $this->vendorLogoUploader = $this->createMock(VendorLogoUploaderInterface::class);
        $this->localeRepository = $this->createMock(RepositoryInterface::class);
        $this->fileLocator = $this->createMock(FileLocatorInterface::class);

        $this->factory = new VendorExampleFactory(
            $this->vendorFactory,
            $this->vendorLogoUploader,
            $this->createMock(RepositoryInterface::class),
            $this->localeRepository,
            $this->fileLocator,
        );

        $this->logoPath = (string) tempnam(sys_get_temp_dir(), 'vendor_logo');
        file_put_contents($this->logoPath, 'image-content');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->logoPath)) {
            unlink($this->logoPath);
        }
    }

    public function testItCreatesAVendorWithTheGivenOptions(): void
    {
        $this->vendorFactory->method('createNew')->willReturn(new Vendor());

        $locale = new Locale();
        $locale->setCode('en_US');
        $this->localeRepository->method('findAll')->willReturn([$locale]);

        $this->fileLocator->method('locate')->willReturn($this->logoPath);
        $this->vendorLogoUploader->expects($this->once())->method('upload');

        $vendor = $this->factory->create([
            'name' => 'Acme',
            'slug' => 'acme',
            'email' => 'acme@example.com',
            'description' => 'Best brand',
            'channels' => [],
            'logo' => $this->logoPath,
        ]);

        $this->assertInstanceOf(VendorInterface::class, $vendor);
        $this->assertSame('Acme', $vendor->getName());
        $this->assertSame('acme@example.com', $vendor->getEmail());
        $this->assertSame('acme', $vendor->getSlug());

        $vendor->setCurrentLocale('en_US');
        $this->assertSame('Best brand', $vendor->getDescription());
        $this->assertNotNull($vendor->getLogoFile());
    }

    public function testItGeneratesDefaultsForMissingOptions(): void
    {
        $this->vendorFactory->method('createNew')->willReturn(new Vendor());
        $this->localeRepository->method('findAll')->willReturn([]);
        $this->fileLocator->method('locate')->willReturn($this->logoPath);

        $vendor = $this->factory->create(['channels' => [], 'logo' => $this->logoPath]);

        $this->assertNotEmpty($vendor->getName());
        $this->assertNotEmpty($vendor->getEmail());
    }
}
