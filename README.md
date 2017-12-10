<h1 align="center">Odiseo Sylius Vendor Plugin</h1>

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
    ];

    return array_merge($preResourceBundles, parent::registerBundles(), $bundles);
}
```
 
3. Import the config.yml:
 
```yml
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/app/config.yml" }
```

4. Import the vendor grid:
 
```yml
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/grids/vendor.yml" }
```

5. Add the admin routes:

```yml
odiseo_sylius_admin_vendor:
   resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/admin_vendor.yml"
```

6. Add the shop routes:

```yml
odiseo_sylius_shop_vendor:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/shop_vendor.yml"
    prefix: /vendors
```
