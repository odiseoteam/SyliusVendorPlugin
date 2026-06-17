<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Api\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use Odiseo\SyliusVendorPlugin\Api\Processor\VendorLogoUploadProcessor;
use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Odiseo\SyliusVendorPlugin\Repository\VendorRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Uploader\VendorLogoUploaderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class VendorLogoUploadProcessorTest extends TestCase
{
    private ProcessorInterface&MockObject $persistProcessor;

    private VendorRepositoryInterface&MockObject $vendorRepository;

    private VendorLogoUploaderInterface&MockObject $vendorLogoUploader;

    private ValidatorInterface&MockObject $validator;

    private VendorLogoUploadProcessor $processor;

    private string $filePath;

    protected function setUp(): void
    {
        $this->persistProcessor = $this->createMock(ProcessorInterface::class);
        $this->vendorRepository = $this->createMock(VendorRepositoryInterface::class);
        $this->vendorLogoUploader = $this->createMock(VendorLogoUploaderInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->processor = new VendorLogoUploadProcessor(
            $this->persistProcessor,
            $this->vendorRepository,
            $this->vendorLogoUploader,
            $this->validator,
        );

        $this->filePath = (string) tempnam(sys_get_temp_dir(), 'vendor_logo');
        file_put_contents($this->filePath, 'image-content');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function testItUploadsTheLogoValidatesAndPersistsTheVendor(): void
    {
        $vendor = new Vendor();
        $vendor->setSlug('acme');

        $this->vendorRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['slug' => 'acme'])
            ->willReturn($vendor);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($vendor, ['groups' => ['odiseo_vendor_logo_create', 'odiseo']]);

        $this->vendorLogoUploader->expects($this->once())
            ->method('upload')
            ->with($vendor);

        $operation = $this->createMock(Operation::class);
        $this->persistProcessor->expects($this->once())
            ->method('process')
            ->willReturn($vendor);

        $result = $this->processor->process(
            null,
            $operation,
            ['slug' => 'acme'],
            ['request' => $this->createRequestWithFile()],
        );

        $this->assertInstanceOf(VendorInterface::class, $result);
        $this->assertNotNull($vendor->getLogoFile());
    }

    public function testItThrowsNotFoundWhenVendorDoesNotExist(): void
    {
        $this->vendorRepository->method('findOneBy')->willReturn(null);

        $this->expectException(NotFoundHttpException::class);

        $this->processor->process(
            null,
            $this->createMock(Operation::class),
            ['slug' => 'missing'],
            ['request' => $this->createRequestWithFile()],
        );
    }

    public function testItFailsWhenNoFileIsSent(): void
    {
        $vendor = new Vendor();
        $this->vendorRepository->method('findOneBy')->willReturn($vendor);

        $this->expectException(\InvalidArgumentException::class);

        $this->processor->process(
            null,
            $this->createMock(Operation::class),
            ['slug' => 'acme'],
            ['request' => new Request()],
        );
    }

    private function createRequestWithFile(): Request
    {
        $file = new UploadedFile($this->filePath, 'logo.png', 'image/png', null, true);

        return new Request([], [], [], [], ['file' => $file]);
    }
}
