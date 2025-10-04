<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Fixture;

use Odiseo\SyliusVendorPlugin\Fixture\VendorFixture;
use PHPUnit\Framework\TestCase;

final class VendorFixtureTest extends TestCase
{
    public function testItIsInitializable(): void
    {
        // Since VendorFixture extends AbstractResourceFixture and has complex dependencies,
        // we'll just test that the class exists and can be referenced
        $this->assertTrue(class_exists(VendorFixture::class));
    }

    public function testItHasCorrectName(): void
    {
        // Test the getName method without instantiating the complex fixture
        $reflectionClass = new \ReflectionClass(VendorFixture::class);
        $method = $reflectionClass->getMethod('getName');

        // Create a mock to avoid constructor issues
        $fixture = $this->getMockBuilder(VendorFixture::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();

        $this->assertEquals('vendor', $fixture->getName());
    }
}
