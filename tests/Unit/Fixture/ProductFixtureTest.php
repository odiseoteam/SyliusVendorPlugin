<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Fixture;

use Odiseo\SyliusVendorPlugin\Fixture\ProductFixture;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\CoreBundle\Fixture\ProductFixture as BaseProductFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

final class ProductFixtureTest extends TestCase
{
    public function testItExtendsTheCoreProductFixture(): void
    {
        $this->assertTrue(is_subclass_of(ProductFixture::class, BaseProductFixture::class));
    }

    public function testItAddsAVendorNodeToTheResourceConfiguration(): void
    {
        $treeBuilder = new TreeBuilder('product');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $fixture = (new \ReflectionClass(ProductFixture::class))->newInstanceWithoutConstructor();
        $method = new \ReflectionMethod(ProductFixture::class, 'configureResourceNode');
        $method->invoke($fixture, $rootNode);

        $children = $rootNode->getNode(true)->getChildren();

        $this->assertArrayHasKey('vendor', $children);
    }
}
