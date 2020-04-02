<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Fixture\Factory;

use Faker\Factory;
use Generator;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VendorExampleFactory extends AbstractExampleFactory
{
    /** @var FactoryInterface */
    private $vendorFactory;

    /** @var ChannelRepositoryInterface */
    private $channelRepository;

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
        RepositoryInterface $localeRepository,
        ?FileLocatorInterface $fileLocator = null
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->channelRepository = $channelRepository;
        $this->localeRepository = $localeRepository;
        $this->fileLocator = $fileLocator;

        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
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

            ->setDefault('logo', function (Options $options): string {
                return __DIR__.'/../../Resources/fixtures/vendor/0'.rand(1, 4).'.png';
            })
            ->setAllowedTypes('logo', ['string'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): VendorInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var VendorInterface $vendor */
        $vendor = $this->vendorFactory->createNew();
        $vendor->setName($this->faker->company);
        $vendor->setSlug($this->faker->slug);
        $vendor->setEmail($this->faker->companyEmail);

        foreach ($options['channels'] as $channel) {
            $vendor->addChannel($channel);
        }

        /** @var string $localeCode */
        foreach ($this->getLocales() as $localeCode) {
            $vendor->setCurrentLocale($localeCode);
            $vendor->setFallbackLocale($localeCode);

            $vendor->setDescription($this->faker->text);
        }

        $vendor->setLogoFile($this->createImage($options['logo']));

        return $vendor;
    }

    /**
     * @param string $imagePath
     * @return UploadedFile
     */
    private function createImage(string $imagePath): UploadedFile
    {
        $imagePath = $this->fileLocator === null ? $imagePath : $this->fileLocator->locate($imagePath);
        if(is_array($imagePath) && count($imagePath) > 0)
            $imagePath = $imagePath[0];

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
}
