# Installation

## 1. Require the plugin

```bash
composer require odiseoteam/sylius-vendor-plugin
```

## 2. Enable the plugin

```php
<?php
// config/bundles.php

return [
    // ...
    Odiseo\SyliusVendorPlugin\OdiseoSyliusVendorPlugin::class => ['all' => true],
];
```

## 3. Import the plugin configuration

```yaml
# config/packages/odiseo_sylius_vendor_plugin.yaml
imports:
    - { resource: "@OdiseoSyliusVendorPlugin/config/config.yaml" }
```

## 4. Import the routes

```yaml
# config/routes/odiseo_sylius_vendor_plugin.yaml
odiseo_sylius_vendor_admin:
    resource: "@OdiseoSyliusVendorPlugin/config/routes/admin.yaml"
    prefix: /admin

odiseo_sylius_vendor_shop:
    resource: "@OdiseoSyliusVendorPlugin/config/routes/shop.yaml"
    prefix: /{_locale}
    requirements:
        _locale: ^[A-Za-z]{2,4}(_([A-Za-z]{4}|[0-9]{3}))?(_([A-Za-z]{2}|[0-9]{3}))?$
```

> The shop routes already include the `/vendors` prefix internally, so you only need to add the
> `/{_locale}` prefix here. The final shop URLs will be `/{_locale}/vendors` and
> `/{_locale}/vendors/{slug}`.

## 5. Make your `Product` vendor-aware

To associate products with vendors, make the `Product` entity implement `VendorAwareInterface` and
use `VendorTrait`:

```php
<?php
// src/Entity/Product/Product.php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements VendorAwareInterface
{
    use VendorTrait;
}
```

Add the shop query helper to your product repository:

```php
<?php
// src/Repository/ProductRepository.php

declare(strict_types=1);

namespace App\Repository;

use Odiseo\SyliusVendorPlugin\Repository\ProductRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Repository\ProductRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    use ProductRepositoryTrait;
}
```

Register the overridden classes:

```yaml
# config/packages/_sylius.yaml
sylius_product:
    resources:
        product:
            classes:
                model: App\Entity\Product\Product
                repository: App\Repository\ProductRepository
```

## 6. Update the database

```bash
php bin/console doctrine:migrations:migrate
```

## What you get out of the box

- The **REST API** is registered automatically — no extra `api_platform` configuration is required.
  See the [API documentation](api.md).
- The **vendor logo** is stored in `public/media/vendor-logo/` through a Gaufrette filesystem and is
  ready to be rendered with the `odiseo_vendor_logo` Liip Imagine filter.
- The admin **Vendors** menu entry is added automatically.
