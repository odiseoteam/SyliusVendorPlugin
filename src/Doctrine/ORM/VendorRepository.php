<?php

namespace Odiseo\SyliusVendorPlugin\Doctrine\ORM;

use Odiseo\SyliusVendorPlugin\Model\ChannelInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class VendorRepository extends EntityRepository implements VendorRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByChannelQuery(ChannelInterface $channel)
    {
        $queryBuilder = $this->createQueryBuilder('v')
            ->innerJoin('v.channel', 'channel')
            ->andWhere('channel = :channel')
            ->setParameter('channel', $channel)
        ;

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function findByChannel(ChannelInterface $channel)
    {
        return $this->findByChannelQuery($channel)->getQuery()->getResult();
    }
}