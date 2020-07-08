<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;

interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    /**
     * @param ChannelInterface $channel
     * @param VendorInterface $vendor
     * @param string $locale
     * @return QueryBuilder
     */
    public function createShopListByVendorQueryBuilder(ChannelInterface $channel, VendorInterface $vendor, string $locale): QueryBuilder;
}
