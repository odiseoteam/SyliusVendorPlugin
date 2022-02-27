<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\ProductFixture as BaseProductFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ProductFixture extends BaseProductFixture
{
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $node = $resourceNode->children();

        $node->scalarNode('vendor');

        parent::configureResourceNode($resourceNode);
    }
}
