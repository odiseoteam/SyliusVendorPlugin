<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Fixture\Factory;

use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ProductExampleFactory as BaseProductExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductExampleFactory extends AbstractExampleFactory
{
    protected OptionsResolver $optionsResolver;

    public function __construct(
        protected BaseProductExampleFactory $baseProductExampleFactory,
        protected RepositoryInterface $vendorRepository,
    ) {
        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = []): ProductInterface
    {
        [$extracted, $remaining] = $this->extractOptions($options, $this->optionsResolver);

        $product = $this->baseProductExampleFactory->create($remaining);

        if ($product instanceof VendorAwareInterface) {
            $product->setVendor($extracted['vendor']);
        }

        return $product;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('vendor', LazyOption::randomOne($this->vendorRepository))
            ->setAllowedTypes('vendor', ['string', VendorInterface::class])
            ->setNormalizer('vendor', LazyOption::findOneBy($this->vendorRepository, 'slug'))
        ;
    }

    private function extractOptions(array $options, OptionsResolver $resolver): array
    {
        $optionsToExtract = array_fill_keys($resolver->getDefinedOptions(), null);
        $extractedOptions = array_intersect_key($options, $optionsToExtract);
        $remainingOptions = array_diff_key($options, $optionsToExtract);

        return [$resolver->resolve($extractedOptions), $remainingOptions];
    }
}
