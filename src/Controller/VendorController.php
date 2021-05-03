<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Controller;

use Odiseo\SyliusVendorPlugin\Entity\VendorInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VendorController extends ResourceController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function updatePositionsAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);
        $vendorsToUpdate = $request->get('vendors');

        if ($configuration->isCsrfProtectionEnabled() && !$this->isCsrfTokenValid('update-vendor-position', $request->request->get('_csrf_token'))) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Invalid csrf token.');
        }

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true) && null !== $vendorsToUpdate) {
            /** @var array $vendorToUpdate */
            foreach ($vendorsToUpdate as $vendorToUpdate) {
                if (!is_numeric($vendorToUpdate['position'])) {
                    throw new HttpException(
                        Response::HTTP_NOT_ACCEPTABLE,
                        sprintf('The vendor position "%s" is invalid.', $vendorToUpdate['position'])
                    );
                }

                /** @var VendorInterface $vendor */
                $vendor = $this->repository->findOneBy(['id' => $vendorToUpdate['id']]);
                $vendor->setPosition((int) $vendorToUpdate['position']);
                $this->manager->flush();
            }
        }

        return new JsonResponse();
    }
}
