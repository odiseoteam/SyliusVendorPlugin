<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ChannelInterface as BaseChannelInterface;

interface ChannelInterface extends BaseChannelInterface
{
    /**
     * @return ArrayCollection
     */
    public function getVendors();

    /**
     * @param ArrayCollection $vendors
     */
    public function setVendors($vendors);
}