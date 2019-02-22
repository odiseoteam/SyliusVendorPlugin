<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;

trait VendorsTrait
{
    /** @var ArrayCollection|VendorInterface[] */
    protected $vendors;

    /**
     * @inheritdoc
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * @inheritdoc
     */
    public function setVendors(ArrayCollection $vendors)
    {
        $this->vendors = $vendors;
    }

    /**
     * @inheritdoc
     */
    public function addVendor(VendorInterface $vendor)
    {
        if (!$this->vendors->contains($vendor)) {
            $this->vendors->add($vendor);
        }
    }

    /**
     * @inheritdoc
     */
    public function removeVendor(VendorInterface $vendor)
    {
        if ($this->vendors->contains($vendor)) {
            $this->vendors->removeElement($vendor);
        }
    }
}
