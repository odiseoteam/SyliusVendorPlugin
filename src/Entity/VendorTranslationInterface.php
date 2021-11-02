<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface VendorTranslationInterface extends
    ResourceInterface,
    TranslationInterface,
    TimestampableInterface
{
    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}
