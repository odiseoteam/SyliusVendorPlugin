<h1 align="center">
    <a href="https://odiseo.com.ar/" target="_blank" title="Odiseo">
        <img src="https://odiseo.com.ar/bundles/odiseoapp/images/logoodiseo.png" alt="Odiseo" />
    </a>
    <br />
    Odiseo Sylius Vendor Plugin
</h1>

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
{{ form_row(form.vendor) }}
```
