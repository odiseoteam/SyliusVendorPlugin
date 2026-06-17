<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\SitemapProvider;

use Doctrine\Common\Collections\Collection;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use SitemapPlugin\Factory\AlternativeUrlFactoryInterface;
use SitemapPlugin\Factory\UrlFactoryInterface;
use SitemapPlugin\Model\ChangeFrequency;
use SitemapPlugin\Model\UrlInterface;
use SitemapPlugin\Provider\UrlProviderInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\RouterInterface;

final class VendorUrlProvider implements UrlProviderInterface
{
    private ChannelInterface $channel;

    /** @var array<string|null> */
    private array $channelLocaleCodes = [];

    public function __construct(
        private readonly VendorRepositoryInterface $vendorRepository,
        private readonly RouterInterface $router,
        private readonly UrlFactoryInterface $urlFactory,
        private readonly AlternativeUrlFactoryInterface $urlAlternativeFactory,
        private readonly LocaleContextInterface $localeContext,
    ) {
    }

    public function getName(): string
    {
        return 'vendors';
    }

    public function generate(ChannelInterface $channel): iterable
    {
        $this->channel = $channel;
        $this->channelLocaleCodes = [];

        $urls = [];
        foreach ($this->vendorRepository->findByChannel($channel) as $vendor) {
            $urls[] = $this->createVendorUrl($vendor);
        }

        return $urls;
    }

    /**
     * @return Collection<array-key, TranslationInterface>
     */
    private function getTranslations(VendorInterface $vendor): Collection
    {
        return $vendor->getTranslations()->filter(function (TranslationInterface $translation): bool {
            return $this->localeInLocaleCodes($translation);
        });
    }

    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return \in_array($translation->getLocale(), $this->getLocaleCodes(), true);
    }

    /**
     * @return array<string|null>
     */
    private function getLocaleCodes(): array
    {
        if ($this->channelLocaleCodes === []) {
            $this->channelLocaleCodes = $this->channel->getLocales()->map(
                static fn (LocaleInterface $locale): ?string => $locale->getCode(),
            )->toArray();
        }

        return $this->channelLocaleCodes;
    }

    private function createVendorUrl(VendorInterface $vendor): UrlInterface
    {
        $vendorUrl = $this->urlFactory->createNew('');
        $vendorUrl->setChangeFrequency(ChangeFrequency::daily());
        $vendorUrl->setPriority(0.7);

        $lastModification = $vendor->getUpdatedAt() ?? $vendor->getCreatedAt();
        if ($lastModification !== null) {
            $vendorUrl->setLastModification($lastModification);
        }

        foreach ($this->getTranslations($vendor) as $translation) {
            $locale = $translation->getLocale();

            if ($locale === null) {
                continue;
            }

            $location = $this->router->generate('odiseo_vendor_shop_vendor_show', [
                'slug' => $vendor->getSlug(),
                '_locale' => $locale,
            ]);

            if ($locale === $this->localeContext->getLocaleCode()) {
                $vendorUrl->setLocation($location);

                continue;
            }

            $vendorUrl->addAlternative($this->urlAlternativeFactory->createNew($location, $locale));
        }

        return $vendorUrl;
    }
}
