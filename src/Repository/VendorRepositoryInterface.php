<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface VendorRepositoryInterface extends RepositoryInterface
{
    /**
     * @param ChannelInterface|null $channel
     * @return QueryBuilder
     */
    public function findByEnabledQueryBuilder(?ChannelInterface $channel): QueryBuilder;

    /**
     * @param ChannelInterface $channel
     * @return array
     */
    public function findByChannel(ChannelInterface $channel): array;

    /**
     * @param string $slug
     * @param string $locale
     * @return VendorInterface|null
     */
    public function findOneBySlug(string $slug, string $locale): ?VendorInterface;
}
