<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Odiseo\SyliusVendorPlugin\Entity\VendorsAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorsTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity
 */
class Channel extends BaseChannel implements VendorsAwareInterface
{
    use VendorsTrait {
        __construct as private initializeVendorsCollection;
    }

    public function __construct()
    {
        parent::__construct();

        $this->initializeVendorsCollection();
    }
}
