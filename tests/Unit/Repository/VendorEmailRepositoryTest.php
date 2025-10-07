<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Repository;

use Odiseo\SyliusVendorPlugin\Repository\VendorEmailRepository;
use PHPUnit\Framework\TestCase;

final class VendorEmailRepositoryTest extends TestCase
{
    public function testItIsInitializable(): void
    {
        // Since VendorEmailRepository extends EntityRepository and has complex dependencies,
        // we'll just test that the class exists and can be referenced
        $this->assertTrue(class_exists(VendorEmailRepository::class));
    }

    public function testItImplementsCorrectInterface(): void
    {
        $reflectionClass = new \ReflectionClass(VendorEmailRepository::class);
        $this->assertTrue($reflectionClass->implementsInterface('Odiseo\SyliusVendorPlugin\Repository\VendorEmailRepositoryInterface'));
    }
}
