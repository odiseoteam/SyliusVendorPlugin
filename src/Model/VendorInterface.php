<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\File;

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
     * @return ChannelInterface
     */
    public function getChannel();

    /**
     * @param ChannelInterface $channel
     */
    public function setChannel(ChannelInterface $channel);

    /**
     * @return ArrayCollection
     */
    public function getProducts();

    /**
     * @param ArrayCollection $products
     */
    public function setProducts($products);

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