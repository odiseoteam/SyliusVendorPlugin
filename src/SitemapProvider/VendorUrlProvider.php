<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\SitemapProvider;

use Doctrine\Common\Collections\Collection;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorTranslation;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
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

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'vendors';
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): iterable
    {
        $urls = [];

        foreach ($this->getVendors() as $vendor) {
            $urls[] = $this->createVendorUrl($vendor);
        }

        return $urls;
    }

    /**
     * @param VendorInterface $vendor
     * @return Collection|TranslationInterface[]
     *
     * @psalm-return Collection<array-key, TranslationInterface>
     */
    private function getTranslations(VendorInterface $vendor): Collection
    {
        return $vendor->getTranslations()->filter(function (TranslationInterface $translation): bool {
            return $this->localeInLocaleCodes($translation);
        });
    }

    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return in_array($translation->getLocale(), $this->getLocaleCodes(), true);
    }

    /**
     * @return iterable
     */
    private function getVendors(): iterable
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        return $this->vendorRepository->findByChannel($channel);
    }

    /**
     * @return array
     */
    private function getLocaleCodes(): array
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        return $channel->getLocales()->map(function (LocaleInterface $locale): ?string {
            return $locale->getCode();
        })->toArray();
    }

    /**
     * @param VendorInterface $vendor
     * @return SitemapUrlInterface
     */
    private function createVendorUrl(VendorInterface $vendor): SitemapUrlInterface
    {
        $vendorUrl = $this->sitemapUrlFactory->createNew();

        $vendorUrl->setChangeFrequency(ChangeFrequency::daily());
        $vendorUrl->setPriority(0.7);

        if (null !== $vendor->getUpdatedAt()) {
            $vendorUrl->setLastModification($vendor->getUpdatedAt());
        } elseif (null !== $vendor->getCreatedAt()) {
            $vendorUrl->setLastModification($vendor->getCreatedAt());
        }

        /** @var VendorTranslation $translation */
        foreach ($this->getTranslations($vendor) as $translation) {
            if (null === $translation->getLocale() || !$this->localeInLocaleCodes($translation)) {
                continue;
            }

            $location = $this->router->generate('odiseo_sylius_vendor_plugin_shop_vendor_show', [
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
