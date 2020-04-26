<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class VendorFixture extends AbstractResourceFixture
{
    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
            ->arrayNode('products')->scalarPrototype()->end()->end()
            ->arrayNode('channels')->scalarPrototype()->end()->end()
            ->scalarNode('name')->cannotBeEmpty()->end()
            ->scalarNode('slug')->cannotBeEmpty()->end()
            ->scalarNode('email')->cannotBeEmpty()->end()
            ->scalarNode('logo')->end()
            ->scalarNode('description')->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'vendor';
    }
}
