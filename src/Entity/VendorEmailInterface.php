<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface VendorEmailInterface extends
    ResourceInterface,
    TimestampableInterface
{
    /**
     * @return string|null
     */
    public function getValue(): ?string;

    /**
     * @param string|null $value
     */
    public function setValue(?string $value): void;

    /**
     * @return VendorInterface|null
     */
    public function getVendor(): ?VendorInterface;

    /**
     * @param VendorInterface|null $vendor
     */
    public function setVendor(?VendorInterface $vendor): void;
}
