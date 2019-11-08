<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface VendorsAwareInterface
{
    /**
     * @return Collection|VendorInterface[]
     */
    public function getVendors(): Collection;

    /**
     * @param VendorInterface $vendor
     * @return bool
     */
    public function hasVendor(VendorInterface $vendor): bool;

    /**
     * @param VendorInterface $vendor
     */
    public function addVendor(VendorInterface $vendor): void;

    /**
     * @param VendorInterface $vendor
     */
    public function removeVendor(VendorInterface $vendor): void;
}
