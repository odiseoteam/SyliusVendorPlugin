<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;

interface ProductInterface extends BaseProductInterface, VendorsAwareInterface
{
}
