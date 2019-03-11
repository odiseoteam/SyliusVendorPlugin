<?php

namespace Odiseo\SyliusVendorPlugin\Form\Extension;

use Odiseo\SyliusVendorPlugin\Form\Type\VendorChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('vendors', VendorChoiceType::class, [
            'multiple' => true,
            'expanded' => false,
            'attr' => [
                'class' => 'fluid search selection'
            ],
            'label' => 'odiseo_sylius_vendor.form.product.select_vendors',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedTypes(): string
    {
        return ProductType::class;
    }
}
