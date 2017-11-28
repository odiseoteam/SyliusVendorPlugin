<h1 align="center">Odiseo Sylius Vendor Plugin</h1>

## Installation

1. Run `composer require odiseoteam/sylius-vendor-plugin`.

2. Add the plugin to the AppKernel but adding it before SyliusResourceBundle
 
3. Import the config.yml:
 
```
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/app/config.yml" }
```

4. Import the vendor grid:
 
```
    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/grids/vendor.yml" }
```

5. Add the admin routes:

```
odiseo_sylius_admin_vendor:
   resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/admin_vendor.yml"
```

6. Add the shop routes:

```
odiseo_sylius_shop_vendor:
    resource: "@OdiseoSyliusVendorPlugin/Resources/config/routing/shop_vendor.yml"
    prefix: /vendors
```