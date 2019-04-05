<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Odiseo\SyliusVendorPlugin\Doctrine\ORM\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class VendorContext implements Context
{
    /** @var FactoryInterface */
    private $vendorFactory;

    /** @var VendorRepositoryInterface */
    private $vendorRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        FactoryInterface $vendorFactory,
        VendorRepositoryInterface $vendorRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->vendorRepository = $vendorRepository;
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
     * @param $quantity
     * @Given the store has( also) :quantity vendors
     */
    public function theStoreHasVendors($quantity)
    {
        for ($i = 1;$i <= $quantity;$i++) {
            $this->saveVendor($this->createVendor('Test'.$i));
        }
    }

    /**
     * @param string $name
     *
     * @return VendorInterface
     */
    private function createVendor(string $name): VendorInterface
    {
        /** @var VendorInterface $vendor */
        $vendor = $this->vendorFactory->createNew();

        $vendor->setName($name);
        $vendor->setEmail('test@odiseo.com.ar');
        $vendor->setCurrentLocale('en_US');
        $vendor->setFallbackLocale('en_US');
        $vendor->setDescription('This is a test');

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
