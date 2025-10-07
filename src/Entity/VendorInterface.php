<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Resource\Model\TranslationInterface;
use Symfony\Component\HttpFoundation\File\File;

interface VendorInterface extends
    ResourceInterface,
    SlugAwareInterface,
    TranslatableInterface,
    ToggleableInterface,
    TimestampableInterface,
    ChannelsAwareInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getEmail(): ?string;

    public function setEmail(?string $email): void;

    public function setLogoFile(?File $file): void;

    public function getLogoFile(): ?File;

    public function setLogoName(?string $logoName): void;

    public function getLogoName(): ?string;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getPosition(): ?int;

    public function setPosition(?int $position): void;

    /**
     * @psalm-return Collection<array-key, ProductInterface>
     */
    public function getProducts(): Collection;

    public function hasProduct(ProductInterface $product): bool;

    public function addProduct(ProductInterface $product): void;

    public function removeProduct(ProductInterface $product): void;

    /**
     * @psalm-return Collection<array-key, VendorEmailInterface>
     */
    public function getExtraEmails(): Collection;

    public function hasExtraEmail(VendorEmailInterface $email): bool;

    public function addExtraEmail(VendorEmailInterface $email): void;

    public function removeExtraEmail(VendorEmailInterface $email): void;

    public function getTranslation(?string $locale = null): TranslationInterface;
}
