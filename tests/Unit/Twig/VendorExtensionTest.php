<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Twig;

use Odiseo\SyliusVendorPlugin\Twig\VendorExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

final class VendorExtensionTest extends TestCase
{
    private VendorExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new VendorExtension();
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorExtension::class, $this->extension);
    }

    public function testItReturnsTwigFunctions(): void
    {
        $functions = $this->extension->getFunctions();

        $this->assertIsArray($functions);
        $this->assertCount(1, $functions);
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
        $this->assertEquals('odiseo_vendor_get_vendor_by_slug', $functions[0]->getName());
    }
}
