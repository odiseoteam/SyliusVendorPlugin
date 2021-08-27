## Sitemap

This plugin suggests installing the Sylius sitemap plugin providing a sitemap for vendors.

### Installation

1. Run `composer require stefandoorn/sitemap-plugin ^2.0@alpha`

2. Enable the plugin in bundles.php

```php
<?php
// config/bundles.php

return [
    // ...
    SitemapPlugin\SitemapPlugin::class => ['all' => true],
];
```

3. Import the providers

```yml
# config/services.yaml
imports:
    ...

    - { resource: "@OdiseoSyliusVendorPlugin/Resources/config/services/sitemap.yaml" }
```

Follow the original [SyliusSitemapPlugin](https://github.com/stefandoorn/sitemap-plugin) documentation.
