<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Fixture\Factory;

use Faker\Factory;
use Faker\Generator;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorExampleFactory extends AbstractExampleFactory
{
    protected Generator $faker;

    protected OptionsResolver $optionsResolver;

    /**
     * @param FactoryInterface<VendorInterface> $vendorFactory
     * @param RepositoryInterface<ChannelInterface> $channelRepository
     * @param RepositoryInterface<LocaleInterface> $localeRepository
     */
    public function __construct(
        protected FactoryInterface $vendorFactory,
        protected VendorLogoUploaderInterface $vendorLogoUploader,
        protected RepositoryInterface $channelRepository,
        protected RepositoryInterface $localeRepository,
        protected FileLocatorInterface $fileLocator,
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
        $imagePath = $this->fileLocator->locate($imagePath);

        return new UploadedFile($imagePath, basename($imagePath));
    }

    protected function getLocales(): iterable
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
                $name = $options['name'];

                if (!is_string($name)) {
                    throw new \InvalidArgumentException('Expected "name" to be a string.');
                }

                return StringInflector::nameToCode($name);
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
