<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Form\Type;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Form\Type\VendorChoiceType;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VendorChoiceTypeTest extends TestCase
{
    private VendorChoiceType $formType;

    private VendorRepositoryInterface $vendorRepository;

    protected function setUp(): void
    {
        $this->vendorRepository = $this->createMock(VendorRepositoryInterface::class);
        $this->formType = new VendorChoiceType($this->vendorRepository);
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorChoiceType::class, $this->formType);
    }

    public function testItConfiguresOptions(): void
    {
        $vendor1 = new Vendor();
        $vendor1->setName('Vendor 1');
        $vendor2 = new Vendor();
        $vendor2->setName('Vendor 2');
        $vendors = [$vendor1, $vendor2];

        $this->vendorRepository->expects($this->once())
            ->method('findBy')
            ->with([], ['name' => 'ASC'])
            ->willReturn($vendors);

        $resolver = new OptionsResolver();
        $this->formType->configureOptions($resolver);

        $options = $resolver->resolve([]);

        $this->assertArrayHasKey('choices', $options);
        // After resolving, choices should be an array with vendor names as keys
        $this->assertIsArray($options['choices']);
        $this->assertArrayHasKey('Vendor 1', $options['choices']);
        $this->assertArrayHasKey('Vendor 2', $options['choices']);
    }

    public function testItHasCorrectBlockPrefix(): void
    {
        $this->assertEquals('odiseo_sylius_vendor_choice', $this->formType->getBlockPrefix());
    }
}
