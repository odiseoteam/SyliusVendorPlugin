<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait VendorsTrait
{
    protected Collection $vendors;

    public function __construct()
    {
        $this->vendors = new ArrayCollection();
    }

    public function getVendors(): Collection
    {
        return $this->vendors;
    }

    public function hasVendor(VendorInterface $vendor): bool
    {
        return $this->vendors->contains($vendor);
    }

    public function addVendor(VendorInterface $vendor): void
    {
        if (!$this->hasVendor($vendor)) {
            $this->vendors->add($vendor);
        }
    }

    public function removeVendor(VendorInterface $vendor): void
    {
        if ($this->hasVendor($vendor)) {
            $this->vendors->removeElement($vendor);
        }
    }
}
