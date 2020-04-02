<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Sylius\Component\Resource\Model\TimestampableTrait;

class VendorEmail implements VendorEmailInterface
{
    use TimestampableTrait;

    /** @var int|null */
    private $id;

    /** @var string|null */
    private $value;

    /** @var VendorInterface */
    protected $vendor;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getVendor(): ?VendorInterface
    {
        return $this->vendor;
    }

    /**
     * {@inheritdoc}
     */
    public function setVendor(?VendorInterface $vendor): void
    {
        $this->vendor = $vendor;
    }
}
