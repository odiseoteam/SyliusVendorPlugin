<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    use VendorsTrait;

    public function __construct()
    {
        parent::__construct();

        $this->vendors = new ArrayCollection();
    }
}