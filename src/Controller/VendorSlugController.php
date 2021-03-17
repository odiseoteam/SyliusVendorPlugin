<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Controller;

use Sylius\Component\Product\Generator\SlugGeneratorInterface;
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

        /** @var SlugGeneratorInterface $slugGenerator */
        $slugGenerator = $this->get('sylius.generator.slug');

        return new JsonResponse([
            'slug' => $slugGenerator->generate($name),
        ]);
    }
}
