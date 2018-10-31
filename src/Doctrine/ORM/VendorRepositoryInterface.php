<?php

namespace Odiseo\SyliusVendorPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Model\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface VendorRepositoryInterface extends RepositoryInterface
{
    /**
     * @param ChannelInterface $channel
     *
     * @return QueryBuilder
     */
    public function findByChannelQuery(ChannelInterface $channel);

    /**
     * @param ChannelInterface $channel
     *
     * @return array
     */
    public function findByChannel(ChannelInterface $channel);

    /**
     * @param string $slug
     *
     * @return VendorInterface
     */
    public function findOneBySlug(string $slug): ?VendorInterface;
}
