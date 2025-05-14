<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Twig;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Twig\Extension\RuntimeExtensionInterface;

class VendorRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        protected VendorRepositoryInterface $vendorRepository,
        protected LocaleContextInterface $localeContext,
    ) {
    }

    public function getVendorBySlug(string $slug, ?string $localeCode = null): ?VendorInterface
    {
        if (!$localeCode) {
            $localeCode = $this->localeContext->getLocaleCode();
        }

        return $this->vendorRepository->findOneBySlug($slug, $localeCode);
    }
}
