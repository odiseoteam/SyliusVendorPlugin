<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface VendorEmailInterface extends
    ResourceInterface,
    VendorAwareInterface,
    TimestampableInterface
{
    public function getValue(): ?string;

    public function setValue(?string $value): void;
}
