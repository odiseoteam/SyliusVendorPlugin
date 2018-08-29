<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;

interface VendorsAwareInterface
{
    /**
     * @return ArrayCollection|VendorInterface[]
     */
    public function getVendors();

    /**
     * @param ArrayCollection|VendorInterface[] $vendors
     */
    public function setVendors(ArrayCollection $vendors);

    /**
     * @param VendorInterface $vendor
     */
    public function addVendor(VendorInterface $vendor);

    /**
     * @param VendorInterface $vendor
     */
    public function removeVendor(VendorInterface $vendor);
}