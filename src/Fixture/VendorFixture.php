<?php

namespace Odiseo\SyliusVendorPlugin\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Odiseo\SyliusVendorPlugin\Model\ChannelInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorFixture extends AbstractFixture
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var FactoryInterface
     */
    protected $vendorFactory;

    /**
     * @var RepositoryInterface
     */
    protected $vendorRepository;

    /**
     * @var ChannelRepositoryInterface
     */
    protected $channelRepository;

    /**
     * @var RepositoryInterface
     */
    protected $localeRepository;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var OptionsResolver
     */
    protected $optionsResolver;

    /**
     * @param ObjectManager $objectManager
     * @param FactoryInterface $vendorFactory
     * @param RepositoryInterface $vendorRepository
     * @param ChannelRepositoryInterface $channelRepository
     * @param RepositoryInterface $localeRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        FactoryInterface $vendorFactory,
        RepositoryInterface $vendorRepository,
        ChannelRepositoryInterface $channelRepository,
        RepositoryInterface $localeRepository
    )
    {
        $this->objectManager = $objectManager;
        $this->vendorFactory = $vendorFactory;
        $this->vendorRepository = $vendorRepository;
        $this->channelRepository = $channelRepository;
        $this->localeRepository = $localeRepository;

        $this->faker = Factory::create();
        $this->optionsResolver =
            (new OptionsResolver())
                ->setRequired('vendors_per_channel')
                ->setAllowedTypes('vendors_per_channel', 'int')
        ;
    }

    /**
     * @inheritDoc
     */
    public function load(array $options): void
    {
        $options = $this->optionsResolver->resolve($options);

        $channels = $this->channelRepository->findAll();

        /** @var ChannelInterface $channel */
        foreach($channels as $channel)
        {
            $imageIndex = 1;
            for($i=1; $i <= $options['vendors_per_channel']; $i++)
            {
                /** @var VendorInterface $vendor */
                $vendor = $this->vendorFactory->createNew();

                $vendor->setName($this->faker->company);
                $vendor->setEmail($this->faker->companyEmail);
                $vendor->addChannel($channel);

                foreach ($this->getLocales() as $localeCode) {
                    $vendor->setCurrentLocale($localeCode);
                    $vendor->setFallbackLocale($localeCode);

                    $vendor->setDescription($this->faker->text);
                }

                $imageFinder = new Finder();
                $imagesPath = __DIR__ . '/../Resources/fixtures/vendor';

                /** @var File $img */
                foreach ($imageFinder->files()->in($imagesPath)->name('0'.$imageIndex.'.png') as $img)
                {
                    if ($img->getRealPath() !== false) {
                        $file = new UploadedFile($img->getRealPath(), $img->getFilename());
                        $vendor->setLogoFile($file);
                    }
                }
                $imageIndex = $imageIndex>=4?1:$imageIndex+1;

                $this->objectManager->persist($vendor);
            }
        }

        $this->objectManager->flush();
    }

    /**
     * @return array
     */
    private function getLocales()
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
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->integerNode('vendors_per_channel')->isRequired()->min(1)->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'vendor';
    }
}
