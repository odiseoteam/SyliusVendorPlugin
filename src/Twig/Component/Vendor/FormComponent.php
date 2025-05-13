<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Twig\Component\Vendor;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\UiBundle\Twig\Component\LiveCollectionTrait;
use Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponentTrait;
use Sylius\Bundle\UiBundle\Twig\Component\TemplatePropTrait;
use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentToolsTrait;

class FormComponent
{
    use ComponentToolsTrait;
    use LiveCollectionTrait;
    use TemplatePropTrait;

    /** @use ResourceFormComponentTrait<VendorInterface> */
    use ResourceFormComponentTrait;

    /**
     * @param RepositoryInterface<VendorInterface> $vendorRepository
     * @param class-string<VendorInterface> $resourceClass
     * @param class-string<AbstractType> $formClass
     */
    public function __construct(
        RepositoryInterface $vendorRepository,
        FormFactoryInterface $formFactory,
        string $resourceClass,
        string $formClass,
        protected readonly SlugGeneratorInterface $slugGenerator,
    ) {
        $this->initialize($vendorRepository, $formFactory, $resourceClass, $formClass);
    }

    #[LiveAction]
    public function generateSlug(): void
    {
        $this->formValues['slug'] = $this->slugGenerator->generate(
            $this->formValues['name'],
        );
    }
}
