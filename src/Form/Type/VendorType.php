<?php

namespace Odiseo\SyliusVendorPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class VendorType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.ui.name',
            ])
            ->add('enabled', CheckboxType::class , [
                'label' => 'sylius.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => VendorTranslationType::class,
                'label' => 'odiseo_sylius_vendor.form.vendor.translations',
            ])
            ->add('email', EmailType::class, [
                'label' => 'odiseo_sylius_vendor.form.vendor.email',
            ])
            ->add('logoFile',  FileType::class, [
                 'label' => 'odiseo_sylius_vendor.form.vendor.logo',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'odiseo_sylius_vendor.form.vendor.channel',
            ])
        ;
    }
}
