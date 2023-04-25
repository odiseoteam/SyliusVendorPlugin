<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Uploader;

use Gaufrette\FilesystemInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Symfony\Component\HttpFoundation\File\File;

final class VendorLogoUploader implements VendorLogoUploaderInterface
{
    public function __construct(
        private FilesystemInterface $filesystem
    ) {
    }

    public function upload(VendorInterface $vendor): void
    {
        if ($vendor->getLogoFile() === null) {
            return;
        }

        /** @var File $file */
        $file = $vendor->getLogoFile();

        if (null !== $vendor->getLogoName() && $this->has($vendor->getLogoName())) {
            $this->remove($vendor->getLogoName());
        }

        do {
            $path = $this->name($file);
        } while ($this->isAdBlockingProne($path) || $this->filesystem->has($path));

        $vendor->setLogoName($path);

        if ($vendor->getLogoName() === null) {
            return;
        }

        if (file_get_contents($file->getPathname()) === false) {
            return;
        }

        $this->filesystem->write(
            $vendor->getLogoName(),
            file_get_contents($file->getPathname()),
            true
        );
    }

    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }

    private function name(File $file): string
    {
        $name = \str_replace('.', '', \uniqid('', true));
        $extension = $file->guessExtension();

        if (\is_string($extension) && '' !== $extension) {
            $name = \sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }

    private function isAdBlockingProne(string $path): bool
    {
        return strpos($path, 'ad') !== false;
    }
}
