<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface VendorRepositoryInterface extends RepositoryInterface
{
    public function createShopListQueryBuilder(
        ChannelInterface $channel,
        array $sorting = []
    ): QueryBuilder;

    public function findByEnabledQueryBuilder(?ChannelInterface $channel): QueryBuilder;

    public function findByChannel(ChannelInterface $channel): array;

    public function findOneBySlug(string $slug, string $locale): ?VendorInterface;
}
