<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Fixture\Factory;

use Faker\Factory;
use Faker\Generator as FakerGenerator;
use Generator;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorExampleFactory implements ExampleFactoryInterface
{
    protected FakerGenerator $faker;

    protected OptionsResolver $optionsResolver;

    public function __construct(
        protected FactoryInterface $vendorFactory,
        protected VendorLogoUploaderInterface $vendorLogoUploader,
        protected RepositoryInterface $channelRepository,
        protected RepositoryInterface $localeRepository,
        protected ?FileLocatorInterface $fileLocator = null,
    ) {
        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

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

        $vendor->setLogoFile($this->createImage($options['logo']));

        $this->vendorLogoUploader->upload($vendor);

        return $vendor;
    }

    protected function createImage(string $imagePath): UploadedFile
    {
        $imagePath = null === $this->fileLocator ? $imagePath : $this->fileLocator->locate($imagePath);

        /**
         * @phpstan-ignore-next-line
         */
        return new UploadedFile($imagePath, basename($imagePath));
    }

    protected function getLocales(): Generator
    {
        /** @var LocaleInterface[] $locales */
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            yield $locale->getCode();
        }
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('channels', LazyOption::randomOnes($this->channelRepository, 3))
            ->setAllowedTypes('channels', 'array')
            ->setNormalizer('channels', LazyOption::findBy($this->channelRepository, 'code'))
            ->setRequired('name')
            ->setAllowedTypes('name', 'string')
            ->setDefault('name', function (Options $_options): string {
                return $this->faker->company();
            })
            ->setRequired('slug')
            ->setAllowedTypes('slug', 'string')
            ->setDefault('slug', function (Options $options): string {
                return StringInflector::nameToCode((string) $options['name']);
            })
            ->setRequired('email')
            ->setAllowedTypes('email', 'string')
            ->setDefault('email', function (Options $_options): string {
                return $this->faker->companyEmail();
            })
            ->setRequired('logo')
            ->setAllowedTypes('logo', 'string')
            ->setDefault('logo', function (Options $_options): string {
                return __DIR__ . '/../../Resources/fixtures/vendor/images/0' . rand(1, 3) . '.png';
            })
            ->setRequired('description')
            ->setAllowedTypes('description', 'string')
            ->setDefault('description', function (Options $_options): string {
                return $this->faker->text();
            })
        ;
    }
}
