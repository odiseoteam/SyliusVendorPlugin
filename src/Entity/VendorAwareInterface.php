<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

interface VendorAwareInterface
{
    /**
     * @return VendorInterface|null
     */
    public function getVendor(): ?VendorInterface;

    /**
     * @param VendorInterface|null $vendor
     */
    public function setVendor(?VendorInterface $vendor): void;
}
