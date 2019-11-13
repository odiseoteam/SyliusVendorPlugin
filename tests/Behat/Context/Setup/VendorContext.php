<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class VendorContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var FactoryInterface */
    private $vendorFactory;

    /** @var VendorRepositoryInterface */
    private $vendorRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $vendorFactory,
        VendorRepositoryInterface $vendorRepository,
        ProductRepositoryInterface $productRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->vendorFactory = $vendorFactory;
        $this->vendorRepository = $vendorRepository;
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $name
     * @Given there is an existing vendor with :name name
     */
    public function thereIsAVendorWithName(string $name): void
    {
        $vendor = $this->createVendor($name);

        $this->saveVendor($vendor);
    }

    /**
     * @param int $quantity
     * @Given the store has( also) :quantity vendors
     */
    public function theStoreHasVendors(int $quantity): void
    {
        for ($i = 1;$i <= $quantity;$i++) {
            $this->saveVendor($this->createVendor('Test'.$i));
        }
    }

    /**
     * @Given this vendor has these products associated with it
     */
    public function thisVendorHasTheseProductsAssociatedWithIt()
    {
        /** @var VendorInterface $vendor */
        $vendor = $this->vendorRepository->findOneBy([
            'name' => 'Test'
        ]);

        $products = $this->productRepository->findAll();

        /** @var ProductInterface $product */
        foreach ($products as $product) {
            $vendor->addProduct($product);
        }

        $this->entityManager->flush();
    }

    /**
     * @param string $name
     * @return VendorInterface
     */
    private function createVendor(string $name): VendorInterface
    {
        /** @var ChannelInterface $channel */
        $channel = $this->sharedStorage->get('channel');

        /** @var VendorInterface $vendor */
        $vendor = $this->vendorFactory->createNew();

        $vendor->setName($name);
        $vendor->setSlug(strtolower($name));
        $vendor->setEmail('test@odiseo.com.ar');
        $vendor->setCurrentLocale('en_US');
        $vendor->setFallbackLocale('en_US');
        $vendor->setDescription('This is a test');

        $vendor->addChannel($channel);

        $uploadedFile = new UploadedFile(__DIR__.'/../../Resources/images/logo_odiseo.png', 'logo_odiseo.png');
        $vendor->setLogoFile($uploadedFile);

        return $vendor;
    }

    /**
     * @param VendorInterface $vendor
     */
    private function saveVendor(VendorInterface $vendor): void
    {
        $this->vendorRepository->add($vendor);
    }
}
