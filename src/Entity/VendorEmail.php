<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Sylius\Component\Resource\Model\TimestampableTrait;

class VendorEmail implements VendorEmailInterface
{
    use VendorTrait;
    use TimestampableTrait;

    protected ?int $id = null;
    protected ?string $value = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }
}
