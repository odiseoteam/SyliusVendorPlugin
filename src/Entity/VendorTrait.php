<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

trait VendorTrait
{
    /** @var VendorInterface|null */
    protected $vendor;

    /**
     * @return VendorInterface|null
     */
    public function getVendor(): ?VendorInterface
    {
        return $this->vendor;
    }

    /**
     * @param VendorInterface|null $vendor
     */
    public function setVendor(?VendorInterface $vendor): void
    {
        $this->vendor = $vendor;
    }
}
