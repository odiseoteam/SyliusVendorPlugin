<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Twig;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Twig\VendorRuntime;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class VendorRuntimeTest extends TestCase
{
    private VendorRuntime $runtime;

    private VendorRepositoryInterface $vendorRepository;

    private LocaleContextInterface $localeContext;

    protected function setUp(): void
    {
        $this->vendorRepository = $this->createMock(VendorRepositoryInterface::class);
        $this->localeContext = $this->createMock(LocaleContextInterface::class);
        $this->runtime = new VendorRuntime($this->vendorRepository, $this->localeContext);
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorRuntime::class, $this->runtime);
    }

    public function testItGetsVendorBySlugWithProvidedLocale(): void
    {
        $vendor = new Vendor();
        $slug = 'test-vendor';
        $locale = 'en_US';

        $this->vendorRepository->expects($this->once())
            ->method('findOneBySlug')
            ->with($slug, $locale)
            ->willReturn($vendor);

        $this->localeContext->expects($this->never())
            ->method('getLocaleCode');

        $result = $this->runtime->getVendorBySlug($slug, $locale);

        $this->assertSame($vendor, $result);
    }

    public function testItGetsVendorBySlugWithContextLocale(): void
    {
        $vendor = new Vendor();
        $slug = 'test-vendor';
        $contextLocale = 'fr_FR';

        $this->localeContext->expects($this->once())
            ->method('getLocaleCode')
            ->willReturn($contextLocale);

        $this->vendorRepository->expects($this->once())
            ->method('findOneBySlug')
            ->with($slug, $contextLocale)
            ->willReturn($vendor);

        $result = $this->runtime->getVendorBySlug($slug);

        $this->assertSame($vendor, $result);
    }
}
