<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Mapping;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Sylius\Component\Resource\Metadata\RegistryInterface;

final class VendorAwareListener implements EventSubscriber
{
    /** @var RegistryInterface */
    private $resourceMetadataRegistry;

    /** @var string */
    private $vendorClass;

    public function __construct(
        RegistryInterface $resourceMetadataRegistry,
        string $vendorClass
    ) {
        $this->resourceMetadataRegistry = $resourceMetadataRegistry;
        $this->vendorClass = $vendorClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $reflection = $classMetadata->reflClass;

        if (!$reflection instanceof \ReflectionClass || $reflection->isAbstract()) {
            return;
        }

        if (
            $reflection->implementsInterface(VendorAwareInterface::class)
        ) {
            $this->mapVendorAware($classMetadata, 'vendor_id', 'products');
        }
    }

    /**
     * @param ClassMetadata $metadata
     * @param string $joinColumn
     * @param string $inversedBy
     */
    private function mapVendorAware(ClassMetadata $metadata, string $joinColumn, string $inversedBy): void
    {
        try {
            $vendorMetadata = $this->resourceMetadataRegistry->getByClass($this->vendorClass);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        if (!$metadata->hasAssociation('vendor')) {
            $metadata->mapManyToOne([
                'fieldName' => 'vendor',
                'targetEntity' => $vendorMetadata->getClass('model'),
                'inversedBy' => $inversedBy,
                'joinColumn' => [
                    'name' => $joinColumn,
                    'referencedColumnName' => 'id'
                ]
            ]);
        }
    }
}
