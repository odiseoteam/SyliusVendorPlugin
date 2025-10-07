<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Form\Extension;

use Odiseo\SyliusVendorPlugin\Form\Extension\ProductTypeExtension;
use Odiseo\SyliusVendorPlugin\Form\Type\VendorChoiceType;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ProductTypeExtensionTest extends TestCase
{
    private ProductTypeExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new ProductTypeExtension();
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(ProductTypeExtension::class, $this->extension);
    }

    public function testItBuildsForm(): void
    {
        $builder = $this->createMock(FormBuilderInterface::class);

        $builder->expects($this->once())
            ->method('add')
            ->with(
                'vendor',
                VendorChoiceType::class,
                $this->callback(function ($options) {
                    $this->assertEquals('odiseo_vendor.form.product.select_vendor', $options['label']);
                    $this->assertArrayHasKey('constraints', $options);
                    $this->assertIsArray($options['constraints']);
                    $this->assertInstanceOf(NotBlank::class, $options['constraints'][0]);

                    return true;
                }),
            );

        $this->extension->buildForm($builder, []);
    }

    public function testItExtendsProductType(): void
    {
        $extendedTypes = $this->extension::getExtendedTypes();

        $this->assertIsIterable($extendedTypes);
        $this->assertContains(ProductType::class, $extendedTypes);
    }
}
