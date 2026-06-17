<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\DependencyInjection;

use Odiseo\SyliusVendorPlugin\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    public function testItIsAConfiguration(): void
    {
        $this->assertInstanceOf(ConfigurationInterface::class, new Configuration());
    }

    public function testItBuildsTheConfigurationTreeWithTheExpectedRootNode(): void
    {
        $treeBuilder = (new Configuration())->getConfigTreeBuilder();

        $this->assertInstanceOf(TreeBuilder::class, $treeBuilder);
        $this->assertSame('odiseo_sylius_vendor', $treeBuilder->buildTree()->getName());
    }

    public function testItProcessesAnEmptyConfigurationWithoutErrors(): void
    {
        $processedConfig = (new Processor())->processConfiguration(new Configuration(), []);

        $this->assertSame([], $processedConfig);
    }
}
