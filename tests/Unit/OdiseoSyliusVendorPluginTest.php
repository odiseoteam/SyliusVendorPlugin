<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit;

use Odiseo\SyliusVendorPlugin\OdiseoSyliusVendorPlugin;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OdiseoSyliusVendorPluginTest extends TestCase
{
    public function testItIsInitializable(): void
    {
        $plugin = new OdiseoSyliusVendorPlugin();

        $this->assertInstanceOf(OdiseoSyliusVendorPlugin::class, $plugin);
        $this->assertInstanceOf(Bundle::class, $plugin);
    }

    public function testItHasCorrectName(): void
    {
        $plugin = new OdiseoSyliusVendorPlugin();

        $this->assertEquals('OdiseoSyliusVendorPlugin', $plugin->getName());
    }
}
