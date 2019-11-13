<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait VendorsTrait
{
    /** @var Collection|VendorInterface[] */
    protected $vendors;

    public function __construct()
    {
        $this->vendors = new ArrayCollection();
    }

    /**
     * @return Collection|VendorInterface[]
     */
    public function getVendors(): Collection
    {
        return $this->vendors;
    }

    /**
     * @param VendorInterface $vendor
     * @return bool
     */
    public function hasVendor(VendorInterface $vendor): bool
    {
        return $this->vendors->contains($vendor);
    }

    /**
     * @param VendorInterface $vendor
     */
    public function addVendor(VendorInterface $vendor): void
    {
        if (!$this->hasVendor($vendor)) {
            $this->vendors->add($vendor);
        }
    }

    /**
     * @param VendorInterface $vendor
     */
    public function removeVendor(VendorInterface $vendor): void
    {
        if ($this->hasVendor($vendor)) {
            $this->vendors->removeElement($vendor);
        }
    }
}
