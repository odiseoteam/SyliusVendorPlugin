<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

trait VendorTrait
{
    protected ?VendorInterface $vendor = null;

    public function getVendor(): ?VendorInterface
    {
        return $this->vendor;
    }

    public function setVendor(?VendorInterface $vendor): void
    {
        $this->vendor = $vendor;
    }
}
