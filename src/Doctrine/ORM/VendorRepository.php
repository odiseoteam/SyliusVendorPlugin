<?php

namespace Odiseo\SyliusVendorPlugin\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping;
use Odiseo\SyliusVendorPlugin\Model\VendorInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use SyliusLabs\AssociationHydrator\AssociationHydrator;

class VendorRepository extends EntityRepository implements VendorRepositoryInterface
{
    /**
     * @var AssociationHydrator
     */
    private $associationHydrator;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManager $entityManager, Mapping\ClassMetadata $class)
    {
        parent::__construct($entityManager, $class);

        $this->associationHydrator = new AssociationHydrator($entityManager, $class);
    }


    /**
     * {@inheritdoc}
     */
    public function findByChannelQuery(ChannelInterface $channel)
    {
        $queryBuilder = $this->createQueryBuilder('v')
            ->innerJoin('v.channels', 'channel')
            ->andWhere('v.enabled = :enabled')
            ->andWhere('channel = :channel')
            ->setParameter('channel', $channel)
            ->setParameter('enabled', true)
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

    /**
     * {@inheritdoc}
     */
    public function findOneBySlug(string $slug): ?VendorInterface
    {
        $vendor = $this->createQueryBuilder('o')
            ->andWhere('o.slug = :slug')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        $this->associationHydrator->hydrateAssociations($vendor, [
            'products',
        ]);

        return $vendor;
    }
}
