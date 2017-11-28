<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface VendorTranslationInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     */
    public function setDescription($description);
}
