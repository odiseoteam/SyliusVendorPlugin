<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class VendorSlugController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function generateAction(Request $request): Response
    {
        /** @var string $name */
        $name = $request->query->get('name');

        return new JsonResponse([
            'slug' => $this->get('sylius.generator.slug')->generate($name),
        ]);
    }
}
