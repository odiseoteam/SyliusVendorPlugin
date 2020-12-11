<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Uploader;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;

interface VendorLogoUploaderInterface
{
    /**
     * @param VendorInterface $vendor
     */
    public function upload(VendorInterface $vendor): void;

    /**
     * @param string $path
     * @return bool
     */
    public function remove(string $path): bool;
}
