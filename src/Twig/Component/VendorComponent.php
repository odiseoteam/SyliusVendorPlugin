<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Twig\Component;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\TwigHooks\Twig\Component\HookableComponentTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
class VendorComponent
{
    use HookableComponentTrait;

    #[ExposeInTemplate(name: 'vendor')]
    public ?VendorInterface $vendor = null;
}
