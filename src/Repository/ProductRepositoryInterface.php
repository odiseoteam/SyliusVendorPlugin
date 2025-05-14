<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;

/**
 * @template T of ProductInterface
 *
 * @extends BaseProductRepositoryInterface<T>
 */
interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    public function createShopListByVendorQueryBuilder(
        ChannelInterface $channel,
        VendorInterface $vendor,
        string $locale,
        array $sorting = [],
    ): QueryBuilder;
}
