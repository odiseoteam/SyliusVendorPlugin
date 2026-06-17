<p align="center">
    <a href="https://odiseo.io/" target="_blank" title="Odiseo">
        <img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/sylius-vendor-plugin.png" alt="Sylius Vendor Plugin" />
    </a>
    <br />
</p>

[![License](https://poser.pugx.org/odiseoteam/sylius-vendor-plugin/license)](https://packagist.org/packages/odiseoteam/sylius-vendor-plugin)
[![Latest Stable Version](https://poser.pugx.org/odiseoteam/sylius-vendor-plugin/v)](https://packagist.org/packages/odiseoteam/sylius-vendor-plugin)
[![PHP Version Require](https://poser.pugx.org/odiseoteam/sylius-vendor-plugin/require/php)](https://packagist.org/packages/odiseoteam/sylius-vendor-plugin)
[![Build](https://github.com/odiseoteam/SyliusVendorPlugin/actions/workflows/build.yaml/badge.svg)](https://github.com/odiseoteam/SyliusVendorPlugin/actions/workflows/build.yaml)
[![Total Downloads](https://poser.pugx.org/odiseoteam/sylius-vendor-plugin/downloads)](https://packagist.org/packages/odiseoteam/sylius-vendor-plugin)
[![Community Chat](https://img.shields.io/badge/community%20chat-slack-FF1493.svg)](https://sylius-devs.slack.com)
[![Support](https://img.shields.io/badge/support-contact%20author-blue)](https://odiseo.io/contact-us)

# Sylius Vendor Plugin

A Sylius plugin that adds vendors (brands) to your store. A vendor is an entity that owns products and is fully manageable from the admin panel.

## Features

- **Vendors per channel** — enable each vendor on the channels you want.
- **Translatable content** — the vendor description is translatable per locale.
- **Multiple emails** — each vendor has a primary email plus an unlimited list of extra emails.
- **Logo management** — logos are stored through a Gaufrette filesystem and rendered with Liip Imagine.
- **Full REST API** — admin CRUD and shop read endpoints, plus a multipart logo upload endpoint,
  wired automatically (see the [API documentation](doc/api.md)).
- **Optional sitemap integration** — vendor URLs in your sitemap via `stefandoorn/sitemap-plugin`.
- **Translated UI** — ships with 13 languages out of the box.
- **Easy to extend** — follows Sylius best practices (resources, twig hooks, services) so every part
  can be overridden.

Supports **Sylius 2.0, 2.1 and 2.2**.

## Requirements

| Package | Version |
|---|---|
| PHP | ^8.2 |
| Sylius | ^2.0 |

## Installation

See the [installation guide](doc/installation.md).

```bash
composer require odiseoteam/sylius-vendor-plugin
```

## Translations

The admin and shop UI strings are available in: English, Spanish, French, German, Italian,
Portuguese (Brazil), Dutch, Polish, Russian, Japanese, Simplified Chinese, Turkish and Arabic.
Translations for locales other than English and Spanish are community-maintained — contributions and
corrections are very welcome via pull request.

## Documentation

- [Installation](doc/installation.md)
- [Usage](doc/usage.md)
- [API](doc/api.md)
- [Fixtures](doc/fixtures.md)
- [Sitemap](doc/sitemap.md)
- [Customization](doc/customization.md)
- [Tests](doc/tests.md)

## Premium features

Do you want advanced features? Take a look at our
[Multi Vendor Marketplace Plugin](https://odiseo.io/plugins-and-bundles/premium/sylius-mvm-plugin),
which turns your Sylius store into a marketplace like Amazon, Etsy or eBay.

## Screenshots

<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_1.png" alt="Vendors admin list" width="650">
<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_2.png" alt="Vendors admin product edit" width="650">
<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_3.png" alt="Vendors shop index" width="650">
<img src="https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/screenshot_4.png" alt="Vendors shop show" width="650">

## Demo

You can see this plugin in action in our Sylius demo application.

- Frontend: [sylius-demo.odiseo.com.ar](https://sylius-demo.odiseo.com.ar)
- Administration: [sylius-demo.odiseo.com.ar/admin](https://sylius-demo.odiseo.com.ar/admin) with `odiseo: odiseo` credentials.

## Contributing

Contributions are welcome! Please read the [contributing guide](CONTRIBUTING.md) and check the
[changelog](CHANGELOG.md) for the project history.

## License

This plugin is released under the [MIT license](LICENSE).

## Credits

This plugin is maintained by [Odiseo](https://odiseo.io). Want us to help you with this plugin or any
Sylius project? Contact us at [team@odiseo.com.ar](mailto:team@odiseo.com.ar).
