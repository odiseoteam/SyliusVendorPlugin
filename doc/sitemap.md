## Sitemap

This plugin suggests installing the Sylius sitemap plugin providing a sitemap for vendors.

### Installation

1. Run `composer require stefandoorn/sitemap-plugin:^3.0` (version `^3.0` is the one compatible with Sylius 2.x).

2. Enable the plugin in `config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    // ...
    SitemapPlugin\SitemapPlugin::class => ['all' => true],
];
```

That's it. This plugin already registers the vendor sitemap provider
(`Odiseo\SyliusVendorPlugin\SitemapProvider\VendorUrlProvider`, tagged `sylius.sitemap_provider`),
so once the sitemap plugin is installed and enabled the vendor URLs are added to the
generated sitemap automatically — no extra service import is needed.

Follow the original [SyliusSitemapPlugin](https://github.com/stefandoorn/sitemap-plugin) documentation for routing and usage.
