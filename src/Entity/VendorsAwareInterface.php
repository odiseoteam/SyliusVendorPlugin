<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface VendorsAwareInterface
{
    /**
     * @psalm-return Collection<array-key, VendorInterface>
     */
    public function getVendors(): Collection;

    public function hasVendor(VendorInterface $vendor): bool;

    public function addVendor(VendorInterface $vendor): void;

    public function removeVendor(VendorInterface $vendor): void;
}
