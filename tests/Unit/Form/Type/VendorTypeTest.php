<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Form\Type;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Form\Type\VendorType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VendorTypeTest extends TestCase
{
    private VendorType $formType;

    protected function setUp(): void
    {
        $this->formType = new VendorType(Vendor::class, ['sylius']);
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorType::class, $this->formType);
    }

    public function testItBuildsForm(): void
    {
        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->exactly(8))
            ->method('add')
            ->willReturnCallback(function ($name, $type, $options) use ($builder) {
                $this->assertContains($name, ['name', 'slug', 'enabled', 'translations', 'email', 'logoFile', 'channels', 'extraEmails']);

                return $builder;
            })
            ->willReturnSelf();

        $this->formType->buildForm($builder, []);
    }

    public function testItConfiguresOptions(): void
    {
        $resolver = new OptionsResolver();
        $this->formType->configureOptions($resolver);

        $options = $resolver->resolve([]);
        $this->assertEquals(Vendor::class, $options['data_class']);
    }

    public function testItHasCorrectBlockPrefix(): void
    {
        $this->assertEquals('odiseo_vendor', $this->formType->getBlockPrefix());
    }

    public function testItRequiresTheLogoValidationGroupWhenCreatingAVendor(): void
    {
        $callback = $this->resolveValidationGroupsCallback();

        $form = $this->createMock(FormInterface::class);
        $form->method('getData')->willReturn(new Vendor());

        // The group name must match config/validation/Vendor.yaml (odiseo_vendor_logo_create),
        // otherwise the logo NotBlank/Image constraints never run on creation.
        $this->assertSame(['sylius', 'odiseo_vendor_logo_create'], $callback($form));
    }

    public function testItDoesNotRequireTheLogoValidationGroupWhenEditingAVendor(): void
    {
        $callback = $this->resolveValidationGroupsCallback();

        $vendor = new Vendor();
        $idProperty = new \ReflectionProperty(Vendor::class, 'id');
        $idProperty->setValue($vendor, 1);

        $form = $this->createMock(FormInterface::class);
        $form->method('getData')->willReturn($vendor);

        $this->assertSame(['sylius'], $callback($form));
    }

    private function resolveValidationGroupsCallback(): callable
    {
        $resolver = new OptionsResolver();
        $this->formType->configureOptions($resolver);

        $callback = $resolver->resolve([])['validation_groups'];
        $this->assertIsCallable($callback);

        return $callback;
    }
}
