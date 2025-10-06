<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class VendorContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var FactoryInterface */
    private $vendorFactory;

    /** @var VendorLogoUploaderInterface */
    private $vendorLogoUploader;

    /** @var VendorRepositoryInterface */
    private $vendorRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ProductFactoryInterface */
    private $productFactory;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $vendorFactory,
        VendorLogoUploaderInterface $vendorLogoUploader,
        VendorRepositoryInterface $vendorRepository,
        ProductRepositoryInterface $productRepository,
        ProductFactoryInterface $productFactory,
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->vendorFactory = $vendorFactory;
        $this->vendorLogoUploader = $vendorLogoUploader;
        $this->vendorRepository = $vendorRepository;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    /**
     * @Given there is an existing vendor with :name name
     */
    public function thereIsAVendorWithName(string $name): void
    {
        $vendor = $this->createVendor($name);

        $this->saveVendor($vendor);
    }

    /**
     * @Given the store has( also) :quantity vendors
     */
    public function theStoreHasVendors(int $quantity): void
    {
        for ($i = 1; $i <= $quantity; ++$i) {
            $this->saveVendor($this->createVendor('Test' . $i));
        }
    }

    /**
     * @Given this vendor has( also) :firstProductName and :secondProductName products associated with it
     */
    public function thisVendorHasProductsAssociatedWithIt(...$productsNames)
    {
        /** @var VendorInterface $vendor */
        $vendor = $this->vendorRepository->findOneBy([
            'name' => 'Test',
        ]);

        foreach ($productsNames as $productName) {
            /** @var ProductInterface|VendorAwareInterface $product */
            $product = $this->productFactory->createNew();
            $product->setCode(StringInflector::nameToUppercaseCode($productName));
            $product->setVendor($vendor);

            $this->productRepository->add($product);
        }
    }

    private function createVendor(string $name): VendorInterface
    {
        /** @var ChannelInterface $channel */
        $channel = $this->sharedStorage->get('channel');

        /** @var VendorInterface $vendor */
        $vendor = $this->vendorFactory->createNew();

        $vendor->setName($name);
        $vendor->setSlug(strtolower($name));
        $vendor->setEmail(strtolower($name) . '@odiseo.com.ar');
        $vendor->setCurrentLocale('en_US');
        $vendor->setFallbackLocale('en_US');
        $vendor->setDescription('This is a test');

        $vendor->addChannel($channel);

        $uploadedFile = new UploadedFile(__DIR__ . '/../../Resources/images/logo_odiseo.png', 'logo_odiseo.png');
        $vendor->setLogoFile($uploadedFile);

        $this->vendorLogoUploader->upload($vendor);

        return $vendor;
    }

    private function saveVendor(VendorInterface $vendor): void
    {
        $this->vendorRepository->add($vendor);
    }
}
