<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class VendorTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('description', TextareaType::class, [
                'label' => 'odiseo_sylius_vendor_plugin.form.vendor.description',
            ])
        ;
    }
}
