<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\SitemapProvider;

use Doctrine\Common\Collections\ArrayCollection;
use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Entity\VendorTranslation;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\SitemapProvider\VendorUrlProvider;
use PHPUnit\Framework\TestCase;
use SitemapPlugin\Factory\AlternativeUrlFactoryInterface;
use SitemapPlugin\Factory\UrlFactoryInterface;
use SitemapPlugin\Model\AlternativeUrlInterface;
use SitemapPlugin\Model\UrlInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\Locale;
use Symfony\Component\Routing\RouterInterface;

final class VendorUrlProviderTest extends TestCase
{
    private VendorRepositoryInterface $vendorRepository;

    private RouterInterface $router;

    private UrlFactoryInterface $urlFactory;

    private AlternativeUrlFactoryInterface $urlAlternativeFactory;

    private LocaleContextInterface $localeContext;

    private VendorUrlProvider $provider;

    protected function setUp(): void
    {
        $this->vendorRepository = $this->createMock(VendorRepositoryInterface::class);
        $this->router = $this->createMock(RouterInterface::class);
        $this->urlFactory = $this->createMock(UrlFactoryInterface::class);
        $this->urlAlternativeFactory = $this->createMock(AlternativeUrlFactoryInterface::class);
        $this->localeContext = $this->createMock(LocaleContextInterface::class);

        $this->provider = new VendorUrlProvider(
            $this->vendorRepository,
            $this->router,
            $this->urlFactory,
            $this->urlAlternativeFactory,
            $this->localeContext,
        );
    }

    public function testItHasName(): void
    {
        $this->assertSame('vendors', $this->provider->getName());
    }

    public function testItGeneratesAUrlWithAlternativesForEachChannelVendor(): void
    {
        $vendor = new Vendor();
        $vendor->setSlug('acme');
        foreach (['en_US', 'es_ES'] as $localeCode) {
            $translation = new VendorTranslation();
            $translation->setLocale($localeCode);
            $vendor->addTranslation($translation);
        }

        $englishLocale = new Locale();
        $englishLocale->setCode('en_US');
        $spanishLocale = new Locale();
        $spanishLocale->setCode('es_ES');

        $channel = $this->createMock(ChannelInterface::class);
        $channel->method('getLocales')->willReturn(new ArrayCollection([$englishLocale, $spanishLocale]));

        $this->vendorRepository->expects($this->once())
            ->method('findByChannel')
            ->with($channel)
            ->willReturn([$vendor]);

        $this->localeContext->method('getLocaleCode')->willReturn('en_US');

        $this->router->method('generate')->willReturnCallback(
            static fn (string $route, array $params): string => sprintf('/%s/vendors/%s', $params['_locale'], $params['slug']),
        );

        $url = $this->createMock(UrlInterface::class);
        $this->urlFactory->method('createNew')->willReturn($url);

        $alternative = $this->createMock(AlternativeUrlInterface::class);
        $this->urlAlternativeFactory->expects($this->once())
            ->method('createNew')
            ->with('/es_ES/vendors/acme', 'es_ES')
            ->willReturn($alternative);

        $url->expects($this->once())->method('setLocation')->with('/en_US/vendors/acme');
        $url->expects($this->once())->method('addAlternative')->with($alternative);

        $urls = $this->provider->generate($channel);

        $this->assertSame([$url], $urls);
    }
}
