<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Mapping;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorsAwareInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Resource\Metadata\RegistryInterface;

final class VendorAwareListener implements EventSubscriber
{
    /** @var RegistryInterface */
    private $resourceMetadataRegistry;

    /** @var string */
    private $vendorClass;

    /** @var string */
    private $productClass;

    /** @var string */
    private $channelClass;

    public function __construct(
        RegistryInterface $resourceMetadataRegistry,
        string $vendorClass,
        string $productClass,
        string $channelClass
    ) {
        $this->resourceMetadataRegistry = $resourceMetadataRegistry;
        $this->vendorClass = $vendorClass;
        $this->productClass = $productClass;
        $this->channelClass = $channelClass;
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

        if ($reflection->isAbstract()) {
            return;
        }

        if (
            $reflection->implementsInterface(ProductInterface::class) &&
            $reflection->implementsInterface(VendorAwareInterface::class)
        ) {
            $this->mapVendorAware($classMetadata, 'product_id', 'products');
        }

        if (
            $reflection->implementsInterface(ChannelInterface::class) &&
            $reflection->implementsInterface(VendorsAwareInterface::class)
        ) {
            $this->mapVendorsAware($classMetadata, 'channel_id', 'channels');
        }

        if ($reflection->implementsInterface(VendorInterface::class) &&
            !$classMetadata->isMappedSuperclass
        ) {
            $this->mapVendor($classMetadata);
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

        if (!$metadata->hasAssociation('vendors')) {
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

    /**
     * @param ClassMetadata $metadata
     * @param string $joinColumn
     * @param string $inversedBy
     */
    private function mapVendorsAware(ClassMetadata $metadata, string $joinColumn, string $inversedBy): void
    {
        try {
            $vendorMetadata = $this->resourceMetadataRegistry->getByClass($this->vendorClass);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        if (!$metadata->hasAssociation('vendors')) {
            $metadata->mapManyToMany([
                'fieldName' => 'vendors',
                'targetEntity' => $vendorMetadata->getClass('model'),
                'inversedBy' => $inversedBy,
                'joinTable' => [
                    'name' => 'odiseo_vendor_'.$inversedBy,
                    'joinColumns' => [[
                        'name' => $joinColumn,
                        'referencedColumnName' => 'id'
                    ]],
                    'inverseJoinColumns' => [[
                        'name' => 'vendor_id',
                        'referencedColumnName' => 'id'
                    ]],
                ]
            ]);
        }
    }

    /**
     * @param ClassMetadata $metadata
     */
    private function mapVendor(ClassMetadata $metadata): void
    {
        try {
            $productMetadata = $this->resourceMetadataRegistry->getByClass($this->productClass);
            $channelMetadata = $this->resourceMetadataRegistry->getByClass($this->channelClass);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        if (!$metadata->hasAssociation('products')) {
            $productConfig = [
                'fieldName' => 'products',
                'targetEntity' => $productMetadata->getClass('model')
            ];

            if (Product::class != $this->productClass) {
                $productConfig = array_merge($productConfig, [
                    'mappedBy' => 'vendor',
                ]);
            }

            $metadata->mapOneToMany($productConfig);
        }

        if (!$metadata->hasAssociation('channels')) {
            $channelConfig = [
                'fieldName' => 'channels',
                'targetEntity' => $channelMetadata->getClass('model')
            ];

            if (Channel::class != $this->channelClass) {
                $channelConfig = array_merge($channelConfig, [
                    'mappedBy' => 'vendors',
                ]);
            }

            $metadata->mapManyToMany($channelConfig);
        }
    }
}
