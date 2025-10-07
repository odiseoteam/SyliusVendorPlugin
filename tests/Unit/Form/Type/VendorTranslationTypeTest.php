<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Form\Type;

use Odiseo\SyliusVendorPlugin\Form\Type\VendorTranslationType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class VendorTranslationTypeTest extends TestCase
{
    private VendorTranslationType $formType;

    protected function setUp(): void
    {
        $this->formType = new VendorTranslationType('VendorTranslation', ['sylius']);
    }

    public function testItIsInitializable(): void
    {
        $this->assertInstanceOf(VendorTranslationType::class, $this->formType);
    }

    public function testItBuildsForm(): void
    {
        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->once())
            ->method('add')
            ->with('description', TextareaType::class, $this->isType('array'))
            ->willReturnSelf();

        $this->formType->buildForm($builder, []);
    }

    public function testItHasCorrectBlockPrefix(): void
    {
        $this->assertEquals('vendor_translation', $this->formType->getBlockPrefix());
    }
}
