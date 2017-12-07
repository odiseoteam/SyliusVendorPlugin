<?php

namespace Odiseo\SyliusVendorPlugin\Form\Type;

use Odiseo\SyliusVendorPlugin\Doctrine\ORM\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VendorChoiceType extends AbstractType
{
    /** @var VendorRepositoryInterface */
    private $vendorRepository;

    /**
     * VendorChoiceType constructor.
     *
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(VendorRepositoryInterface $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['multiple']) {
            $builder->addModelTransformer(new CollectionToArrayTransformer());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $criteria = [];
        $orderBy = ['name' => 'ASC'];

        $resolver->setDefaults(array(
            'choices' => function (Options $options) use ($criteria, $orderBy): array {
                $vendors = $this->vendorRepository->findBy($criteria, $orderBy);

                $choices = [];
                /** @var VendorInterface $vendor */
                foreach ($vendors as $vendor)
                {
                    $choices[$vendor->getName()] = $vendor;
                }

                return $choices;
            },
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'odiseo_sylius_vendor_choice';
    }
}
