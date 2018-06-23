<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    /** @var ArrayCollection|VendorInterface[] */
    protected $vendors;

    public function __construct()
    {
        parent::__construct();

        $this->vendors = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * @inheritdoc
     */
    public function setVendors(ArrayCollection $vendors)
    {
        $this->vendors = $vendors;
    }

    /**
     * @inheritdoc
     */
    public function addVendor(VendorInterface $vendor)
    {
        if(!$this->vendors->contains($vendor)) {
            $this->vendors->add($vendor);
            $vendor->addProduct($this);
        }
    }

    /**
     * @inheritdoc
     */
    public function removeVendor(VendorInterface $vendor)
    {
        if($this->vendors->contains($vendor)) {
            $this->vendors->removeElement($vendor);
            $vendor->removeProduct($this);
        }
    }
}