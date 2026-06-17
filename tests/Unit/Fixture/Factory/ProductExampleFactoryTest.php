<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Fixture\Factory;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Fixture\Factory\ProductExampleFactory;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ProductExampleFactory as BaseProductExampleFactory;
use Sylius\Component\Core\Model\Product;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Tests\Odiseo\SyliusVendorPlugin\Entity\Product as VendorAwareProduct;

final class ProductExampleFactoryTest extends TestCase
{
    public function testItSetsTheVendorOnAVendorAwareProduct(): void
    {
        $vendor = new Vendor();
        $vendor->setSlug('acme');

        $baseFactory = $this->createMock(BaseProductExampleFactory::class);
        $baseFactory->method('create')->willReturn(new VendorAwareProduct());

        $vendorRepository = $this->createMock(RepositoryInterface::class);
        $vendorRepository->method('findOneBy')->willReturn($vendor);

        $factory = new ProductExampleFactory($baseFactory, $vendorRepository);

        $product = $factory->create(['vendor' => 'acme']);

        $this->assertInstanceOf(VendorAwareProduct::class, $product);
        $this->assertSame($vendor, $product->getVendor());
    }

    public function testItLeavesNonVendorAwareProductsUntouched(): void
    {
        $vendor = new Vendor();

        $baseFactory = $this->createMock(BaseProductExampleFactory::class);
        $baseFactory->method('create')->willReturn(new Product());

        $vendorRepository = $this->createMock(RepositoryInterface::class);
        $vendorRepository->method('findOneBy')->willReturn($vendor);

        $factory = new ProductExampleFactory($baseFactory, $vendorRepository);

        $product = $factory->create(['vendor' => 'acme']);

        $this->assertInstanceOf(Product::class, $product);
    }
}
