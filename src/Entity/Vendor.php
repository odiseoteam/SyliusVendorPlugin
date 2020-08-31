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

    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $name;

    /** @var string|null */
    protected $slug;

    /** @var string|null */
    protected $email;

    /** @var File|null */
    protected $logoFile;

    /** @var string|null */
    protected $logoName;

    /**
     * @var Collection|ChannelInterface[]
     *
     * @psalm-var Collection<array-key, ChannelInterface>
     */
    protected $channels;

    /**
     * @var Collection|ProductInterface[]
     *
     * @psalm-var Collection<array-key, ProductInterface>
     */
    protected $products;

    /**
     * @var Collection|VendorEmailInterface[]
     *
     * @psalm-var Collection<array-key, VendorEmailInterface>
     */
    protected $extraEmails;

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->channels = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->extraEmails = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): ?string
    {
        /** @var VendorTranslationInterface $vendorTranslation */
        $vendorTranslation = $this->getTranslation();

        return $vendorTranslation->getDescription();
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(?string $description): void
    {
        /** @var VendorTranslationInterface $vendorTranslation */
        $vendorTranslation = $this->getTranslation();

        $vendorTranslation->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug(?string $slug = null): void
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogoFile(?File $file): void
    {
        $this->logoFile = $file;

        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogoName(?string $logoName): void
    {
        $this->logoName = $logoName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoName(): ?string
    {
        return $this->logoName;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    /**
     * {@inheritdoc}
     */
    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }

    /**
     * {@inheritdoc}
     */
    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);

            if ($channel instanceof VendorsAwareInterface) {
                $channel->addVendor($this);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);

            if ($channel instanceof VendorsAwareInterface) {
                $channel->removeVendor($this);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product): void
    {
        if (!$this->hasProduct($product)) {
            $this->products->add($product);

            if ($product instanceof VendorAwareInterface) {
                $product->setVendor($this);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product): void
    {
        if ($this->hasProduct($product)) {
            $this->products->removeElement($product);

            if ($product instanceof VendorAwareInterface) {
                $product->setVendor(null);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExtraEmails(): Collection
    {
        return $this->extraEmails;
    }

    /**
     * {@inheritdoc}
     */
    public function hasExtraEmail(VendorEmailInterface $email): bool
    {
        return $this->extraEmails->contains($email);
    }

    /**
     * {@inheritdoc}
     */
    public function addExtraEmail(VendorEmailInterface $email): void
    {
        if (!$this->hasExtraEmail($email)) {
            $this->extraEmails->add($email);
            $email->setVendor($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeExtraEmail(VendorEmailInterface $email): void
    {
        if ($this->hasExtraEmail($email)) {
            $this->extraEmails->removeElement($email);
            $email->setVendor(null);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): TranslationInterface
    {
        return new VendorTranslation();
    }
}
