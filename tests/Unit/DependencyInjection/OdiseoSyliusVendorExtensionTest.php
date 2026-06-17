<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\DependencyInjection;

use Odiseo\SyliusVendorPlugin\DependencyInjection\OdiseoSyliusVendorExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class OdiseoSyliusVendorExtensionTest extends TestCase
{
    public function testItRegistersThePluginApiPlatformMappingPath(): void
    {
        $container = new ContainerBuilder();
        $container->registerExtension($this->createApiPlatformExtension());

        (new OdiseoSyliusVendorExtension())->prepend($container);

        $configs = $container->getExtensionConfig('api_platform');

        $paths = [];
        foreach ($configs as $config) {
            foreach ($config['mapping']['paths'] ?? [] as $path) {
                $paths[] = $path;
            }
        }

        $this->assertNotEmpty($paths, 'The plugin should prepend at least one api_platform mapping path.');

        $registeredOne = false;
        foreach ($paths as $path) {
            if (str_ends_with($path, '/config/api_platform') && is_dir($path)) {
                $registeredOne = true;
            }
        }

        $this->assertTrue($registeredOne, 'The plugin config/api_platform directory should be registered and exist.');
    }

    public function testItDoesNotRegisterApiPlatformMappingWhenExtensionIsMissing(): void
    {
        $container = new ContainerBuilder();

        (new OdiseoSyliusVendorExtension())->prepend($container);

        $this->assertSame([], $container->getExtensionConfig('api_platform'));
    }

    private function createApiPlatformExtension(): ExtensionInterface
    {
        $extension = $this->createMock(ExtensionInterface::class);
        $extension->method('getAlias')->willReturn('api_platform');

        return $extension;
    }
}
