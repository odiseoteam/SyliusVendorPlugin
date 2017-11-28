<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Sylius\Component\Resource\Model\AbstractTranslation;

class VendorTranslation extends AbstractTranslation implements VendorTranslationInterface
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $description;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
