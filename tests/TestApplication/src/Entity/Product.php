<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements VendorAwareInterface
{
    use VendorTrait;
}
