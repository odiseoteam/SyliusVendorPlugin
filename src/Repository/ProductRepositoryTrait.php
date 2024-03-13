<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Component\Core\Model\ChannelInterface;

trait ProductRepositoryTrait
{
    abstract public function createQueryBuilder($alias, $indexBy = null);

    public function createShopListByVendorQueryBuilder(
        ChannelInterface $channel,
        VendorInterface $vendor,
        string $locale,
        array $sorting = [],
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

        if (isset($sorting['price'])) {
            $subQuery = $this->createQueryBuilder('m')
                ->select('min(v.position)')
                ->innerJoin('m.variants', 'v')
                ->andWhere('m.id = :product_id')
                ->andWhere('v.enabled = :enabled')
            ;

            $queryBuilder
                ->addSelect('variant')
                ->addSelect('channelPricing')
                ->innerJoin('o.variants', 'variant')
                ->innerJoin('variant.channelPricings', 'channelPricing')
                ->andWhere('channelPricing.channelCode = :channelCode')
                ->andWhere(
                    $queryBuilder->expr()->in(
                        'variant.position',
                        str_replace(':product_id', 'o.id', $subQuery->getDQL()),
                    ),
                )
                ->setParameter('channelCode', $channel->getCode())
                ->setParameter('enabled', true)
            ;
        }

        return $queryBuilder;
    }
}
