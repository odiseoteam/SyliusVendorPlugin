<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

interface VendorAwareInterface
{
    public function getVendor(): ?VendorInterface;

    public function setVendor(?VendorInterface $vendor): void;
}
