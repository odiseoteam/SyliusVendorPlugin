<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class VendorExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('odiseo_vendor_get_vendor_by_slug', [VendorRuntime::class, 'getVendorBySlug']),
        ];
    }
}
