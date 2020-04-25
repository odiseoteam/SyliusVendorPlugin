<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Fixture\Factory;

use Faker\Factory;
use Generator;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VendorExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $vendorFactory;

    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    /** @var RepositoryInterface */
    private $productRepository;

    /** @var RepositoryInterface */
    private $localeRepository;

    /** @var \Faker\Generator */
    private $faker;

    /** @var FileLocatorInterface|null */
    private $fileLocator;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function __construct(
        FactoryInterface $vendorFactory,
        ChannelRepositoryInterface $channelRepository,
        RepositoryInterface $productRepository,
        RepositoryInterface $localeRepository,
        ?FileLocatorInterface $fileLocator = null
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->channelRepository = $channelRepository;
        $this->productRepository = $productRepository;
        $this->localeRepository = $localeRepository;
        $this->fileLocator = $fileLocator;

        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): VendorInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var VendorInterface $vendor */
        $vendor = $this->vendorFactory->createNew();
        $vendor->setName($options['name']);
        $vendor->setEmail($options['email']);

        /** @var string $localeCode */
        foreach ($this->getLocales() as $localeCode) {
            $vendor->setCurrentLocale($localeCode);
            $vendor->setFallbackLocale($localeCode);

            $vendor->setDescription($options['description']);
            $vendor->setSlug($options['slug']);
        }

        foreach ($options['channels'] as $channel) {
            $vendor->addChannel($channel);
        }

        foreach ($options['products'] as $product) {
            $vendor->addProduct($product);
        }

        $vendor->setLogoFile($this->createImage($options['logo']));

        return $vendor;
    }

    private function createImage(string $imagePath): UploadedFile
    {
        /** @var string $imagePath */
        $imagePath = null === $this->fileLocator ? $imagePath : $this->fileLocator->locate($imagePath);

        return new UploadedFile($imagePath, basename($imagePath));
    }

    /**
     * @return Generator
     */
    private function getLocales(): Generator
    {
        /** @var LocaleInterface[] $locales */
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            yield $locale->getCode();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('channels', LazyOption::randomOnes($this->channelRepository, 3))
            ->setAllowedTypes('channels', 'array')
            ->setNormalizer('channels', LazyOption::findBy($this->channelRepository, 'code'))
            ->setDefault('products', LazyOption::randomOnes($this->productRepository, 3))
            ->setAllowedTypes('products', 'array')
            ->setNormalizer('products', LazyOption::findBy($this->productRepository, 'code'))
            ->setRequired('name')
            ->setAllowedTypes('name', 'string')
            ->setDefault('name', function (Options $options): string {
                return $this->faker->company;
            })
            ->setRequired('slug')
            ->setAllowedTypes('slug', 'string')
            ->setDefault('slug', function (Options $options): string {
                return StringInflector::nameToCode((string) $options['name']);
            })
            ->setRequired('email')
            ->setAllowedTypes('email', 'string')
            ->setDefault('email', function (Options $options): string {
                return $this->faker->companyEmail;
            })
            ->setRequired('logo')
            ->setAllowedTypes('logo', 'string')
            ->setDefault('logo', function (Options $options): string {
                return __DIR__.'/../../Resources/fixtures/vendor/images/0'.rand(1, 3).'.png';
            })
            ->setRequired('description')
            ->setAllowedTypes('description', 'string')
            ->setDefault('description', function (Options $options): string {
                return $this->faker->text;
            })
        ;
    }
}
