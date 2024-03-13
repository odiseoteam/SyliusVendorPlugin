<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\EventListener;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class VendorLogoUploadListener
{
    public function __construct(
        private VendorLogoUploaderInterface $uploader,
    ) {
    }

    public function uploadLogo(GenericEvent $event): void
    {
        $vendor = $event->getSubject();
        Assert::isInstanceOf($vendor, VendorInterface::class);

        $this->uploader->upload($vendor);
    }
}
