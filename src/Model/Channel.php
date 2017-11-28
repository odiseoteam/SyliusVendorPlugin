<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\Channel as BaseChannel;

class Channel extends BaseChannel implements ChannelInterface
{
    /** @var ArrayCollection */
    protected $vendors;

    public function __construct()
    {
        parent::__construct();

        $this->vendors = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * @param ArrayCollection $vendors
     */
    public function setVendors($vendors)
    {
        $this->vendors = $vendors;
    }
}