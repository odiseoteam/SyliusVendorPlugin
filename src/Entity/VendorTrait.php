<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

trait VendorTrait
{
    #[ORM\ManyToOne(targetEntity: VendorInterface::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: "vendor_id", referencedColumnName: "id", nullable: false)]
    protected ?VendorInterface $vendor = null;

    public function getVendor(): ?VendorInterface
    {
        return $this->vendor;
    }

    public function setVendor(?VendorInterface $vendor): void
    {
        $this->vendor = $vendor;
    }
}
