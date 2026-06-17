<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Functional\Api;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\RouterInterface;

/**
 * Guards the API Platform wiring: the plugin registers its own mapping path in the extension,
 * so these routes only exist if that registration keeps working.
 */
final class VendorApiRoutingTest extends KernelTestCase
{
    /**
     * @dataProvider expectedApiRoutes
     */
    public function testApiRouteIsRegistered(string $routeName, string $expectedPath): void
    {
        self::bootKernel(['environment' => 'test']);

        /** @var RouterInterface $router */
        $router = self::getContainer()->get('router');
        $route = $router->getRouteCollection()->get($routeName);

        $this->assertNotNull($route, sprintf('API route "%s" should be registered.', $routeName));
        $this->assertSame($expectedPath, $route->getPath());
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function expectedApiRoutes(): iterable
    {
        yield 'admin collection' => ['odiseo_vendor_api_admin_vendor_get_collection', '/api/v2/admin/vendors'];
        yield 'admin get' => ['odiseo_vendor_api_admin_vendor_get', '/api/v2/admin/vendors/{slug}'];
        yield 'admin post' => ['odiseo_vendor_api_admin_vendor_post', '/api/v2/admin/vendors'];
        yield 'admin put' => ['odiseo_vendor_api_admin_vendor_put', '/api/v2/admin/vendors/{slug}'];
        yield 'admin delete' => ['odiseo_vendor_api_admin_vendor_delete', '/api/v2/admin/vendors/{slug}'];
        yield 'admin logo upload' => ['odiseo_vendor_api_admin_vendor_logo_post', '/api/v2/admin/vendors/{slug}/logo'];
        yield 'shop collection' => ['odiseo_vendor_api_shop_vendor_get_collection', '/api/v2/shop/vendors'];
        yield 'shop get' => ['odiseo_vendor_api_shop_vendor_get', '/api/v2/shop/vendors/{slug}'];
    }
}
