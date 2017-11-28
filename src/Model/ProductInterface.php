<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;

interface ProductInterface extends BaseProductInterface
{
    /**
     * @return VendorInterface
     */
    public function getVendor();

    /**
     * @param VendorInterface $vendor
     */
    public function setVendor(VendorInterface $vendor);
}