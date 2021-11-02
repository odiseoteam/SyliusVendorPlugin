<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\HttpFoundation\File\File;

class Vendor implements VendorInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }
    use TimestampableTrait;
    use ToggleableTrait;

    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $slug = null;
    protected ?string $email = null;
    protected ?File $logoFile = null;
    protected ?string $logoName = null;
    protected ?int $position = null;

    /**
     * @psalm-var Collection<array-key, ChannelInterface>
     */
    protected Collection $channels;

    /**
     * @psalm-var Collection<array-key, ProductInterface>
     */
    protected Collection $products;

    /**
     * @psalm-var Collection<array-key, VendorEmailInterface>
     */
    protected Collection $extraEmails;

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->channels = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->extraEmails = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        /** @var VendorTranslationInterface $vendorTranslation */
        $vendorTranslation = $this->getTranslation();

        return $vendorTranslation->getDescription();
    }

    public function setDescription(?string $description): void
    {
        /** @var VendorTranslationInterface $vendorTranslation */
        $vendorTranslation = $this->getTranslation();

        $vendorTranslation->setDescription($description);
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug = null): void
    {
        $this->slug = $slug;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setLogoFile(?File $file): void
    {
        $this->logoFile = $file;

        $this->setUpdatedAt(new \DateTime());
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function setLogoName(?string $logoName): void
    {
        $this->logoName = $logoName;
    }

    public function getLogoName(): ?string
    {
        return $this->logoName;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }

    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);

            if ($channel instanceof VendorsAwareInterface) {
                $channel->addVendor($this);
            }
        }
    }

    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);

            if ($channel instanceof VendorsAwareInterface) {
                $channel->removeVendor($this);
            }
        }
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->hasProduct($product)) {
            $this->products->add($product);

            if ($product instanceof VendorAwareInterface) {
                $product->setVendor($this);
            }
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->hasProduct($product)) {
            $this->products->removeElement($product);

            if ($product instanceof VendorAwareInterface) {
                $product->setVendor(null);
            }
        }
    }

    public function getExtraEmails(): Collection
    {
        return $this->extraEmails;
    }

    public function hasExtraEmail(VendorEmailInterface $email): bool
    {
        return $this->extraEmails->contains($email);
    }

    public function addExtraEmail(VendorEmailInterface $email): void
    {
        if (!$this->hasExtraEmail($email)) {
            $this->extraEmails->add($email);
            $email->setVendor($this);
        }
    }

    public function removeExtraEmail(VendorEmailInterface $email): void
    {
        if ($this->hasExtraEmail($email)) {
            $this->extraEmails->removeElement($email);
            $email->setVendor(null);
        }
    }

    protected function createTranslation(): TranslationInterface
    {
        return new VendorTranslation();
    }
}
