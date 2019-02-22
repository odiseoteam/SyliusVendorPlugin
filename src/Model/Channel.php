<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\Channel as BaseChannel;

class Channel extends BaseChannel implements ChannelInterface
{
    use VendorsTrait;

    public function __construct()
    {
        parent::__construct();

        $this->vendors = new ArrayCollection();
    }
}
