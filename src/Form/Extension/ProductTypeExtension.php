<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Form\Extension;

use Odiseo\SyliusVendorPlugin\Form\Type\VendorChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('vendor', VendorChoiceType::class, [
            'label' => 'odiseo_sylius_vendor_plugin.form.product.select_vendor',
            'required' => false
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
