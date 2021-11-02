<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\TimestampableTrait;

class VendorTranslation extends AbstractTranslation implements VendorTranslationInterface
{
    use TimestampableTrait;

    protected ?int $id = null;
    private ?string $description = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
