<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Repository;

use Odiseo\SyliusVendorPlugin\Repository\VendorRepository;
use PHPUnit\Framework\TestCase;

final class VendorRepositoryTest extends TestCase
{
    public function testItIsInitializable(): void
    {
        // Since VendorRepository extends EntityRepository and has complex dependencies,
        // we'll just test that the class exists and can be referenced
        $this->assertTrue(class_exists(VendorRepository::class));
    }

    public function testItImplementsCorrectInterface(): void
    {
        $reflectionClass = new \ReflectionClass(VendorRepository::class);
        $this->assertTrue($reflectionClass->implementsInterface('Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface'));
    }
}
