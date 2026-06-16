<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Twig\Component\Vendor;

use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Form\Type\VendorType;
use Odiseo\SyliusVendorPlugin\Twig\Component\Vendor\FormComponent;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;

final class FormComponentTest extends TestCase
{
    private SlugGeneratorInterface $slugGenerator;

    private FormComponent $component;

    protected function setUp(): void
    {
        $this->slugGenerator = $this->createMock(SlugGeneratorInterface::class);

        $this->component = new FormComponent(
            $this->createMock(RepositoryInterface::class),
            $this->createMock(FormFactoryInterface::class),
            Vendor::class,
            VendorType::class,
            $this->slugGenerator,
        );
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(FormComponent::class, $this->component);
    }

    public function testItGeneratesTheSlugFromTheName(): void
    {
        $this->slugGenerator->expects($this->once())
            ->method('generate')
            ->with('My Vendor')
            ->willReturn('my-vendor');

        $this->component->formValues = ['name' => 'My Vendor', 'slug' => ''];

        $this->component->generateSlug();

        $this->assertSame('my-vendor', $this->component->formValues['slug']);
    }
}
