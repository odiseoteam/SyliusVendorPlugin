<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Symfony\Component\HttpFoundation\File\File;

class Vendor implements VendorInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }
    use TimestampableTrait;
    use ToggleableTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $slug;

    /** @var string */
    protected $email;

    /** @var ChannelInterface */
    protected $channel;

    /** @var ArrayCollection */
    protected $products;

    /** @var File */
    protected $logoFile;

    /** @var string */
    protected $logoName;

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->products = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation()
    {
        return new VendorTranslation();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->getTranslation()->getDescription();
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->getTranslation()->setDescription($description);
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * {@inheritdoc}
     */
    public function setChannel(ChannelInterface $channel)
    {
        $this->channel = $channel;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogoFile(File $file)
    {
        $this->logoFile = $file;

        if($file)
        {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogoName($logoName)
    {
        $this->logoName = $logoName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoName()
    {
        return $this->logoName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}