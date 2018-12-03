<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\SitemapProvider;

use Doctrine\Common\Collections\Collection;
use Odiseo\SyliusVendorPlugin\Doctrine\ORM\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorTranslationInterface;
use SitemapPlugin\Factory\SitemapUrlFactoryInterface;
use SitemapPlugin\Model\ChangeFrequency;
use SitemapPlugin\Model\SitemapUrlInterface;
use SitemapPlugin\Provider\UrlProviderInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\RouterInterface;

final class VendorUrlProvider implements UrlProviderInterface
{
    /** @var VendorRepositoryInterface */
    private $vendorRepository;

    /** @var RouterInterface */
    private $router;

    /** @var SitemapUrlFactoryInterface */
    private $sitemapUrlFactory;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(
        VendorRepositoryInterface $vendorRepository,
        RouterInterface $router,
        SitemapUrlFactoryInterface $sitemapUrlFactory,
        LocaleContextInterface $localeContext,
        ChannelContextInterface $channelContext
    ) {
        $this->vendorRepository = $vendorRepository;
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
        $this->localeContext = $localeContext;
        $this->channelContext = $channelContext;
    }

    public function getName(): string
    {
        return 'vendors';
    }

    public function generate(): iterable
    {
        $urls = [];

        foreach ($this->getVendors() as $vendor) {
            $urls[] = $this->createVendorUrl($vendor);
        }

        return $urls;
    }

    private function getTranslations(VendorInterface $vendor): Collection
    {
        return $vendor->getTranslations()->filter(function (TranslationInterface $translation) {
            return $this->localeInLocaleCodes($translation);
        });
    }

    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return in_array($translation->getLocale(), $this->getLocaleCodes());
    }

    private function getVendors(): iterable
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        return $this->vendorRepository->findByChannel($channel);
    }

    private function getLocaleCodes(): array
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        return $channel->getLocales()->map(function (LocaleInterface $locale) {
            return $locale->getCode();
        })->toArray();
    }

    private function createVendorUrl(VendorInterface $vendor): SitemapUrlInterface
    {
        $vendorUrl = $this->sitemapUrlFactory->createNew();

        $vendorUrl->setChangeFrequency(ChangeFrequency::daily());
        $vendorUrl->setPriority(0.7);

        if ($vendor->getUpdatedAt()) {
            $vendorUrl->setLastModification($vendor->getUpdatedAt());
        } elseif ($vendor->getCreatedAt()) {
            $vendorUrl->setLastModification($vendor->getCreatedAt());
        }

        /** @var VendorTranslationInterface $translation */
        foreach ($this->getTranslations($vendor) as $translation) {
            if (!$translation->getLocale() || !$this->localeInLocaleCodes($translation)) {
                continue;
            }

            $location = $this->router->generate('odiseo_sylius_vendor_shop_vendor_show', [
                'slug' => $vendor->getSlug(),
                '_locale' => $translation->getLocale(),
            ]);

            if ($translation->getLocale() === $this->localeContext->getLocaleCode()) {
                $vendorUrl->setLocalization($location);

                continue;
            }

            $vendorUrl->addAlternative($location, $translation->getLocale());
        }

        return $vendorUrl;
    }
}
