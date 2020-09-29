<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class VendorRepository extends EntityRepository implements VendorRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByEnabledQueryBuilder(?ChannelInterface $channel): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('v')
            ->andWhere('v.enabled = :enabled')
            ->setParameter('enabled', true)
        ;

        if ($channel instanceof ChannelInterface) {
            $queryBuilder->innerJoin('v.channels', 'channel')
                ->andWhere('channel = :channel')
                ->setParameter('channel', $channel)
            ;
        }

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function findByChannel(ChannelInterface $channel): array
    {
        return $this->findByEnabledQueryBuilder($channel)->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBySlug(string $slug): ?VendorInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.slug = :slug')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
