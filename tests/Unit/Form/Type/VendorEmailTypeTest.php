<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Form\Type;

use Odiseo\SyliusVendorPlugin\Entity\VendorEmail;
use Odiseo\SyliusVendorPlugin\Form\Type\VendorEmailType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VendorEmailTypeTest extends TestCase
{
    private VendorEmailType $formType;

    protected function setUp(): void
    {
        $this->formType = new VendorEmailType(VendorEmail::class, ['sylius']);
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorEmailType::class, $this->formType);
    }

    public function testItBuildsForm(): void
    {
        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->once())
            ->method('add')
            ->with('value', EmailType::class, $this->isType('array'))
            ->willReturnSelf();

        $this->formType->buildForm($builder, []);
    }

    public function testItConfiguresOptions(): void
    {
        $resolver = new OptionsResolver();
        $this->formType->configureOptions($resolver);

        $options = $resolver->resolve([]);
        $this->assertEquals(VendorEmail::class, $options['data_class']);
    }

    public function testItHasCorrectBlockPrefix(): void
    {
        $this->assertEquals('vendor_email', $this->formType->getBlockPrefix());
    }
}
