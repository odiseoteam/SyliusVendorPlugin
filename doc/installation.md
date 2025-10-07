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
# config/packages/_sylius.yaml
imports:
    # ...
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/config.yaml" }
```

4. Add the shop and admin routes

```yml
# config/routes.yaml
odiseo_sylius_vendor_admin:
    resource: "@OdiseoSyliusVendorPlugin/config/routes/admin.yaml"

odiseo_sylius_vendor_shop:
    resource: "@OdiseoSyliusVendorPlugin/config/routes/shop.yaml"
    prefix: /{_locale}
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

// ...
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

6. Add the vendor select box to the product form edit page. So, you need to run `mkdir -p templates/bundles/SyliusAdminBundle/Product/Tab` then `cp vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/views/Product/Tab/_details.html.twig templates/bundles/SyliusAdminBundle/Product/Tab/_details.html.twig` and then add the form widget

```twig
{# ... #}
{{ form_row(form.enabled) }}
{{ form_row(form.vendor) }}
{# ... #}
```

7. Create logo folder: run `mkdir public/media/vendor-logo -p` and insert a .gitkeep file in that folder

8. Finish the installation updating the database schema and installing assets

```
php bin/console doctrine:migrations:migrate
php bin/console sylius:theme:assets:install
php bin/console cache:clear
```
