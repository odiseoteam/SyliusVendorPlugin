<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    /** @var VendorInterface */
    protected $vendor;

    /**
     * @return VendorInterface
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param VendorInterface $vendor
     */
    public function setVendor(VendorInterface $vendor)
    {
        $this->vendor = $vendor;
    }
}