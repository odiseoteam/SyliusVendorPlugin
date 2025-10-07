<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Form\Extension;

use Odiseo\SyliusVendorPlugin\Form\Type\VendorChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('vendor', VendorChoiceType::class, [
            'label' => 'odiseo_vendor.form.product.select_vendor',
            'constraints' => [
                new NotBlank([
                    'message' => 'odiseo_vendor.product.vendor.not_blank',
                    'groups' => ['sylius'],
                ]),
            ],
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
