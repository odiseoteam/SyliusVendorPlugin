## Installation

1. Run `composer require odiseoteam/sylius-vendor-plugin --no-scripts`

2. Enable the plugin in bundles.php

```php
<?php
// config/bundles.php

return [
    // ...
    Odiseo\SyliusVendorPlugin\OdiseoSyliusVendorPlugin::class => ['all' => true],
];
```

3. Import the plugin configurations

```yml
# config/packages/odiseo_sylius_vendor_plugin.yaml
imports:
    - { resource: "@OdiseoSyliusVendorPlugin/config/config.yaml" }
```

4. Add the shop and admin routes

```yml
# config/routes/odiseo_sylius_vendor_plugin.yaml
odiseo_sylius_vendor_admin:
    resource: "@OdiseoSyliusVendorPlugin/config/routes/admin.yaml"
    prefix: /admin

odiseo_sylius_vendor_shop:
    resource: "@OdiseoSyliusVendorPlugin/config/routes/shop.yaml"
    prefix: /{_locale}/vendors
    requirements:
        _locale: ^[A-Za-z]{2,4}(_([A-Za-z]{4}|[0-9]{3}))?(_([A-Za-z]{2}|[0-9]{3}))?$
```

5. Include traits and override the models

```php
<?php
// src/Entity/Product/Product.php

// ...
use Doctrine\ORM\Mapping as ORM;
use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements VendorAwareInterface
{
    use VendorTrait;

    // ...
}
```

```php
<?php
// src/Repository/ProductRepository.php

namespace App\Repository;

use Odiseo\SyliusVendorPlugin\Repository\ProductRepositoryInterface;
use Odiseo\SyliusVendorPlugin\Repository\ProductRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    use ProductRepositoryTrait;
    
    // ...
}
```

```yml
# config/packages/_sylius.yaml
sylius_product:
    resources:
        product:
            classes:
                model: App\Entity\Product
                repository: App\Repository\ProductRepository
```

6. Finish the installation updating the database schema

```
php bin/console doctrine:migrations:migrate
```
