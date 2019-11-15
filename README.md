<h1 align="center">
    <a href="https://odiseo.com.ar/" target="_blank" title="Odiseo">
        <img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/sylius-vendor-plugin.png" alt="Sylius Vendor Plugin" />
    </a>
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
    <p align="center"><a href="https://sylius.com/plugins/" target="_blank"><img src="https://sylius.com/assets/badge-approved-by-sylius.png" width="100"></a></p>
</h1>

## Description

This is a Sylius Plugin that add vendors (brands) to your store. The vendor is an entity that sells products and are fully customizable by the admin.

Features:

* Vendors by Channel: You can specify what vendors will be enabled for different stores.

* Vendors with translations: Vendor's information are translatable.

* Templates: This plugin has shop views for list and show vendors.

* Sitemap: All shop pages are connected with the [Sitemap Plugin](https://github.com/stefandoorn/sitemap-plugin).

Support Sylius version 1.3+.

<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_1.png" alt="Vendors admin list">
<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_2.png" alt="Vendors admin product edit">
<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_3.png" alt="Vendors shop index">
<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_4.png" alt="Vendors shop show">

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
];
```

3. Import the plugin configurations

```yml
# config/packages/_sylius.yaml
imports:
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/config.yaml" }
```

4. Add the shop and admin routes

```yml
# config/routes/odiseo_sylius_vendor_plugin.yaml
odiseo_sylius_vendor_plugin_admin:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/admin.yaml"
    prefix: /admin

odiseo_sylius_vendor_plugin_shop:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/shop.yaml"
    prefix: /{_locale}/vendors
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
```

5. This plugin includes an API version. If you want to use it you have to add the route

```yml
# config/routes/odiseo_sylius_vendor_plugin.yaml
odiseo_sylius_vendor_plugin_api:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/api.yaml"
    prefix: /api
```

6. Include traits

```php
<?php
// src/Entity/Channel/Channel.php

// ...
use Doctrine\ORM\Mapping as ORM;
use Odiseo\SyliusVendorPlugin\Entity\VendorsAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorsTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;
// ...

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity
 */
class Channel extends BaseChannel implements VendorsAwareInterface
{
    use VendorsTrait {
        __construct as private initializeVendorsCollection;
    }

    public function __construct()
    {
        parent::__construct();

        $this->initializeVendorsCollection();
    }

    // ...
}
```

```php
<?php
// src/Entity/Product/Product.php

// ...
use Doctrine\ORM\Mapping as ORM;
use Odiseo\SyliusVendorPlugin\Entity\VendorAwareInterface;
use Odiseo\SyliusVendorPlugin\Entity\VendorTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
// ...

/**
 * @ORM\Table(name="sylius_product")
 * @ORM\Entity
 */
class Product extends BaseProduct implements VendorAwareInterface
{
    use VendorTrait;

    // ...
}
```

7. Add the vendor select box to the product form edit page. So, you need to run `mkdir -p templates/bundles/SyliusAdminBundle/Product/Tab` then `cp vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/views/Product/Tab/_details.html.twig templates/bundles/SyliusAdminBundle/Product/Tab/_details.html.twig` and then add the form widget

```twig
{# ... #}
{{ form_row(form.code) }}
{{ form_row(form.enabled) }}
{{ form_row(form.vendor) }}
{# ... #}
```

8. Create logo folder: run `mkdir public/media/vendor-logo -p` and insert a .gitkeep file in that folder

9. Finish the installation updating the database schema and installing assets

```
php bin/console doctrine:schema:update --force
php bin/console sylius:theme:assets:install
```

## Usage

For the administration you will have the Vendor menu.
Feel free to modify the plugin templates like you want.

### Partial routes

To render vendor by channel you can do something like this:

```twig
{{ render(url('odiseo_sylius_vendor_plugin_shop_partial_vendor_by_channel', {'template': '@OdiseoSyliusVendorPlugin/Shop/Vendor/_vendor.html.twig'})) }}
```

For forms use the validation group `odiseo`

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
