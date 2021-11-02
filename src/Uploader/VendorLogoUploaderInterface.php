<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Uploader;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;

interface VendorLogoUploaderInterface
{
    public function upload(VendorInterface $vendor): void;

    public function remove(string $path): bool;
}
