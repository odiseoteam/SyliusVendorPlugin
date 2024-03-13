<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Form\Type;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VendorChoiceType extends AbstractType
{
    public function __construct(
        private VendorRepositoryInterface $vendorRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var bool $multiple */
        $multiple = $options['multiple'];
        if ($multiple) {
            $builder->addModelTransformer(new CollectionToArrayTransformer());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $criteria = [];
        $orderBy = ['name' => 'ASC'];

        $resolver->setDefaults([
            'choices' => function (Options $_options) use ($criteria, $orderBy): array {
                $vendors = $this->vendorRepository->findBy($criteria, $orderBy);

                $choices = [];
                /** @var VendorInterface $vendor */
                foreach ($vendors as $vendor) {
                    $choices[$vendor->getName()] = $vendor;
                }

                return $choices;
            },
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'odiseo_sylius_vendor_choice';
    }
}
