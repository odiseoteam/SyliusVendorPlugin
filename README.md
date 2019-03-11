<h1 align="center">
    <a href="https://odiseo.com.ar/" target="_blank" title="Odiseo">
        <img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/logo_odiseo.png" alt="Odiseo" width="200px" />
    </a>
    <br />
    Odiseo Sylius Vendor Plugin
    <br />
    <a href="https://packagist.org/packages/odiseoteam/sylius-vendor-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/odiseoteam/sylius-vendor-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/odiseoteam/sylius-vendor-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/odiseoteam/sylius-vendor-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/odiseoteam/SyliusVendorPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/odiseoteam/SyliusVendorPlugin/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/odiseoteam/SyliusVendorPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/odiseoteam/SyliusVendorPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/odiseoteam/sylius-vendor-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/odiseoteam/sylius-vendor-plugin/downloads" />
    </a>
</h1>

## Description

This plugin add vendors (Brands) to the Sylius products. The vendors are fully customizable by the admin.

Now supporting Sylius 1.4 with Symfony 4 + Flex structure.

<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_1.png" alt="Vendors admin">

## Demo

You can see this plugin in action in our Sylius Demo application.

- Frontend: [sylius-demo.odiseo.com.ar](https://sylius-demo.odiseo.com.ar). 
- Administration: [sylius-demo.odiseo.com.ar/admin](https://sylius-demo.odiseo.com.ar/admin) with `odiseo: odiseo` credentials.

## Installation

1. Run `composer require odiseoteam/sylius-vendor-plugin`

2. Enable the plugin in bundles.php

```php
<?php

return [
    // ...
    Vich\UploaderBundle\VichUploaderBundle::class => ['all' => true],
    Odiseo\SyliusVendorPlugin\OdiseoSyliusVendorPlugin::class => ['all' => true],
    // ...
];
```
 
3. Import the plugin configurations
 
```yml
imports:
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/config.yml" }
```

4. Add the shop and admin routes

```yml
odiseo_sylius_vendor_admin:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/admin.yml"
    prefix: /admin

odiseo_sylius_vendor_shop:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/shop.yml"
    prefix: /{_locale}
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
```

5. Include traits

```php
<?php
// src/Entity/Channel/Channel.php

// ...
use Odiseo\SyliusVendorPlugin\Model\VendorsAwareInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorsTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;
// ...

/**
 * @MappedSuperclass
 * @Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements VendorsAwareInterface
{
    use VendorsTrait;

    // ...
}
```

```php
<?php
// src/Entity/Product/Product.php

// ...
use Odiseo\SyliusVendorPlugin\Model\VendorsAwareInterface;
use Odiseo\SyliusVendorPlugin\Model\VendorsTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
// ...

/**
 * @MappedSuperclass
 * @Table(name="sylius_product")
 */
class Product extends BaseProduct implements VendorsAwareInterface
{
    use VendorsTrait;

    // ...
}
```

6. Add the vendor select box to the product form edit page. So, you need to run `mkdir -p templates/bundles/SyliusAdminBundle/Product/Tab` then `cp vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/views/Product/Tab/_details.html.twig templates/bundles/SyliusAdminBundle/Product/Tab/_details.html.twig` and then add the form widget

```twig
{# ... #}
{{ form_row(form.vendors) }}
{# ... #}
```

7. Create logo folder: run `mkdir public/media/vendor-logo -p` and insert a .gitkeep file in that folder

8. Finish the installation updating the database schema and installing assets
   
```
php bin/console doctrine:schema:update --force
php bin/console sylius:theme:assets:install
```

## Fixtures

This plugin comes with fixtures:

### Vendors

Simply add this configuration on your fixture suite:

```yml
vendor:
    options:
        vendors_per_channel: 12
```

## Test the plugin

You can follow the instructions to test this plugins in the proper documentation page: [Test the plugin](doc/tests.md).
    
## Credits

This plugin is maintained by <a href="https://odiseo.com.ar">Odiseo</a>. Want us to help you with this plugin or any Sylius project? Contact us on <a href="mailto:team@odiseo.com.ar">team@odiseo.com.ar</a>.
