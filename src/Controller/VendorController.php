<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Controller;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Webmozart\Assert\Assert;

class VendorController extends ResourceController
{
    public function updateVendorPositionsAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);
        $vendors = $request->get('vendors');

        $this->validateCsrfProtection($request, $configuration);

        if ($this->shouldProductsPositionsBeUpdated($request, $vendors)) {
            /** @var Session $session */
            $session = $request->getSession();

            /**
             * @var int $id
             * @var string $position
             */
            foreach ($vendors as $id => $position) {
                try {
                    $this->updatePositions($position, $id);
                } catch (\InvalidArgumentException $exception) {
                    $session->getFlashBag()->add('error', $exception->getMessage());

                    return $this->redirectHandler->redirectToReferer($configuration);
                }
            }

            $this->manager->flush();
        }

        return $this->redirectHandler->redirectToReferer($configuration);
    }

    private function validateCsrfProtection(Request $request, RequestConfiguration $configuration): void
    {
        /** @var string|null $token */
        $token = $request->request->get('_csrf_token');
        if ($configuration->isCsrfProtectionEnabled() && !$this->isCsrfTokenValid('update-vendor-position', $token)) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Invalid csrf token.');
        }
    }

    private function shouldProductsPositionsBeUpdated(Request $request, ?array $vendors): bool
    {
        return in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true) && null !== $vendors;
    }

    private function updatePositions(string $position, int $id): void
    {
        Assert::numeric($position, sprintf('The position "%s" is invalid.', $position));

        /** @var VendorInterface $vendorFromBase */
        $vendorFromBase = $this->repository->findOneBy(['id' => $id]);
        $vendorFromBase->setPosition((int) $position);
    }
}
