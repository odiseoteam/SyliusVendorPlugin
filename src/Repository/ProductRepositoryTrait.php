<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;

trait ProductRepositoryTrait
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
    public function createShopListByVendorQueryBuilder(
        ChannelInterface $channel,
        VendorInterface $vendor,
        string $locale
    ): QueryBuilder {
        $queryBuilder = $this->createQueryBuilder('o')
            ->distinct()
            ->addSelect('translation')
            ->addSelect('productTaxon')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->innerJoin('o.productTaxons', 'productTaxon');

        $queryBuilder
            ->andWhere(':channel MEMBER OF o.channels')
            ->andWhere('o.enabled = true')
            ->andWhere('o.vendor = :vendor')
            ->setParameter('locale', $locale)
            ->setParameter('channel', $channel)
            ->setParameter('vendor', $vendor)
        ;

        return $queryBuilder;
    }
}
