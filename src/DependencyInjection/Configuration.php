<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UnusedVariable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('odiseo_sylius_vendor');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
