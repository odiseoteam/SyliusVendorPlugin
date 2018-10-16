<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\File;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ChannelInterface;

interface VendorInterface extends SlugAwareInterface, VendorTranslationInterface, TranslatableInterface, ToggleableInterface, TimestampableInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @return ArrayCollection|ChannelInterface[]
     */
    public function getChannels();

    /**
     * @param ArrayCollection $channel
     */
    public function setChannels(ArrayCollection $channel);

    /**
     * @param ChannelInterface $channel
     */
    public function addChannel(ChannelInterface $channel);

    /**
     * @param ChannelInterface $channel
     */
    public function removeChannel(ChannelInterface $channel);

    /**
     * @return ArrayCollection|ProductInterface[]
     */
    public function getProducts();

    /**
     * @param ArrayCollection $products
     */
    public function setProducts(ArrayCollection $products);

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product);

    /**
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product);

    /**
     * @param File $file
     */
    public function setLogoFile(File $file);

    /**
     * @return File
     */
    public function getLogoFile();

    /**
     * @param $logoName
     */
    public function setLogoName($logoName);

    /**
     * @return string
     */
    public function getLogoName();

    /**
     * @return string
     */
    public function __toString();
}