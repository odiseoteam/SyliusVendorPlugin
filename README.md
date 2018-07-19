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

This plugin add vendors to the Sylius products. The vendors are fully customizable by the admin.

<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_1.png" alt="Vendors admin">

## Installation

1. Run `composer require odiseoteam/sylius-vendor-plugin`.

2. Add the plugin to the AppKernel but add it before SyliusResourceBundle. To do that you need change the registerBundles like this:

```php
public function registerBundles(): array
{
    $preResourceBundles = [
        new \Odiseo\SyliusVendorPlugin\OdiseoSyliusVendorPlugin(),
    ];

    $bundles = [
        ...
        //This plugin use the vich uploader bundle
        new \Vich\UploaderBundle\VichUploaderBundle(),
    ];

    return array_merge($preResourceBundles, parent::registerBundles(), $bundles);
}
```
 
3. Import the configurations on your config.yml:
 
```yml
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/app/config.yml" }
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/grids/vendor.yml" }
```

5. Add the shop and admin routes:

```yml
odiseo_sylius_admin_vendor:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/admin_vendor.yml"
    prefix: /admin

odiseo_sylius_shop_vendor:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/shop_vendor.yml"
    prefix: /{_locale}/vendors
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
```

6. Add the vendor form attribute to the admin. So, you need to create "app/Resources/SyliusAdminBundle/views/Product/Tab/_details.html.twig"

```twig
{# ... #}
{{ form_row(form.vendors) }}
{# ... #}
```

7. Update your schema and/or migrations.

## Fixtures

This plugin comes with fixtures:

### Vendors

Simply add this configuration on your fixture suite:

```yml
vendor:
    options:
        vendors_per_channel: 12
```

## Credits

This plugins is maintained by <a href="https://odiseo.com.ar">Odiseo</a>, a team of senior developers. Contact us: <a href="mailto:team@odiseo.com.ar">team@odiseo.com.ar</a>.
