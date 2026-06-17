<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Api\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webmozart\Assert\Assert;

/**
 * Handles the multipart logo upload for a vendor, reusing the same uploader as the admin UI.
 *
 * @implements ProcessorInterface<VendorInterface, VendorInterface>
 */
final readonly class VendorLogoUploadProcessor implements ProcessorInterface
{
    /**
     * @param ProcessorInterface<VendorInterface, VendorInterface> $persistProcessor
     */
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private VendorRepositoryInterface $vendorRepository,
        private VendorLogoUploaderInterface $vendorLogoUploader,
        private ValidatorInterface $validator,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): VendorInterface
    {
        $slug = $uriVariables['slug'] ?? null;
        Assert::string($slug);

        $vendor = $this->vendorRepository->findOneBy(['slug' => $slug]);
        if (!$vendor instanceof VendorInterface) {
            throw new NotFoundHttpException(sprintf('Vendor with slug "%s" does not exist.', $slug));
        }

        $request = $context['request'] ?? null;
        Assert::isInstanceOf($request, Request::class);

        $file = $request->files->get('file');
        Assert::isInstanceOf($file, File::class, 'No file with the key "file" was sent in the request.');

        $vendor->setLogoFile($file);

        $this->validator->validate($vendor, ['groups' => ['odiseo_vendor_logo_create', 'odiseo']]);

        $this->vendorLogoUploader->upload($vendor);

        return $this->persistProcessor->process($vendor, $operation, $uriVariables, $context);
    }
}
