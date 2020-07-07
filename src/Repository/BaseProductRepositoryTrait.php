<?php

/*
 * This file is part of the Odiseo Marketplace Plugin package.
 *
 * Copyright (c) 2018-2020 Odiseo Team - Diego D'amico
 */

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;

trait BaseProductRepositoryTrait
{
    /**
     * @param $alias
     * @param null $indexBy
     * @return mixed
     */
    abstract public function createQueryBuilder($alias, $indexBy = null);

    /**
     * {@inheritdoc}
     */
    public function createListByVendorQueryBuilder(VendorInterface $vendor, string $locale, $taxonId = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->andWhere('o.vendor = :vendor')
            ->setParameter('locale', $locale)
            ->setParameter('vendor', $vendor)
        ;

        if (null !== $taxonId) {
            $queryBuilder
                ->innerJoin('o.productTaxons', 'productTaxon')
                ->andWhere('productTaxon.taxon = :taxonId')
                ->setParameter('taxonId', $taxonId)
            ;
        }

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function findByVendorAndNamePart(VendorInterface $vendor, string $phrase, string $locale, ?int $limit = null): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->andWhere('o.vendor = :vendor')
            ->andWhere('translation.name LIKE :name')
            ->setParameter('vendor', $vendor)
            ->setParameter('name', '%' . $phrase . '%')
            ->setParameter('locale', $locale)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findByEnabledAndChannel(VendorInterface $vendor, ChannelInterface $channel): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.vendor = :vendor')
            ->andWhere('o.enabled = true')
            ->andWhere(':channel MEMBER OF o.channels')
            ->setParameter('vendor', $vendor)
            ->setParameter('channel', $channel)
            ->getQuery()
            ->getResult()
            ;
    }
}
