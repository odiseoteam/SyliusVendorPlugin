# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Identity

This is **odiseoteam/sylius-vendor-plugin** — a Sylius 2.x plugin that adds Vendor (Brand) entities to products. The plugin is production code distributed via Composer, not a skeleton. The namespace is `Odiseo\SyliusVendorPlugin`; tests use `Tests\Odiseo\SyliusVendorPlugin`.

## Development Commands

### Docker Environment (Recommended)
```bash
make init            # Bootstrap containers + composer install + frontend build
make up / make down  # Start/stop containers
make php-shell       # Shell into PHP container
make database-init   # Create DB and run migrations
make load-fixtures   # Load Sylius fixtures
make database-reset  # Drop, recreate, migrate (no fixtures)
```

### Testing
```bash
# PHPUnit — suites: unit, integration, functional, non-unit, all
vendor/bin/phpunit                          # all suites
vendor/bin/phpunit --testsuite unit         # unit only
make phpunit                                # Docker

# Behat
vendor/bin/behat --strict --tags="~@javascript&&~@mink:chromedriver"  # non-JS
make behat                                                              # Docker (non-JS)

# JS Behat requires Chrome headless + running server on port 8080
APP_ENV=test symfony server:start --port=8080 --daemon
vendor/bin/behat --strict --tags="@javascript,@mink:chromedriver"
```

### Code Quality
```bash
vendor/bin/phpstan analyse -c phpstan.neon   # PHPStan (level max)
vendor/bin/ecs check src tests               # Coding standards
make phpstan / make ecs                      # Docker equivalents
```

## Architecture

### Entity Model
`Vendor` is the central entity with:
- **Translatable** (`VendorTranslation` holds `description`) via Sylius `TranslatableTrait`
- **Toggleable**, **Timestampable** via Sylius traits
- Logo stored via Gaufrette filesystem (`odiseo_vendor_logo` adapter → `public/media/vendor-logo/`), managed by `VendorLogoUploader`
- Many-to-many with `ChannelInterface` and `ProductInterface`
- One-to-many with `VendorEmail` (extra notification addresses)
- `VendorsTrait` / `VendorsTrait` / `VendorAwareInterface` for extending host entities (e.g. `Product`)

### Plugin Registration
- **Plugin class**: `src/OdiseoSyliusVendorPlugin.php` — extends `Bundle`, uses `SyliusPluginTrait`
- **DI Extension**: `src/DependencyInjection/OdiseoSyliusVendorExtension.php` — extends `AbstractResourceExtension`, prepends Doctrine migrations (must run after `Sylius\Bundle\CoreBundle\Migrations`)
- **Services**: split under `config/services/*.yaml`, imported via `config/services.yaml`
- **Doctrine ORM**: XML mappings in `config/doctrine/`
- **Validation**: YAML files in `config/validation/`

### Service Groups
| File | Contents |
|---|---|
| `services/uploader.yaml` | `VendorLogoUploader` + Gaufrette wiring |
| `services/event_listener.yaml` | `VendorLogoUploadListener` (triggers upload on flush) |
| `services/form.yaml` | `VendorType`, `VendorTranslationType`, `VendorEmailType`, `VendorChoiceType`, `ProductTypeExtension` |
| `services/twig.yaml` | `VendorExtension` + `VendorRuntime` (Twig functions) |
| `services/twig_component.yaml` | `VendorComponent` (UX Twig Component with `HookableComponentTrait`) |
| `services/sitemap.yaml` | `VendorUrlProvider` (optional, for `stefandoorn/sitemap-plugin`) |
| `services/fixture.yaml` | `VendorFixture` + `VendorExampleFactory` |

### Routing
- Admin: `config/routes/admin.yaml` → includes `admin/vendor.yaml`
- Shop: `config/routes/shop.yaml` → includes `shop/vendor.yaml` under `/vendors` prefix
- Route name pattern: `odiseo_vendor_shop_vendor_show` (slug parameter)

### Test Application
`tests/TestApplication/` is the embedded Sylius app used for Behat and integration tests. It:
- Registers the plugin in `config/bundles.php`
- Imports `@OdiseoSyliusVendorPlugin/config/config.yaml` in its `config/config.yaml`
- Overrides `sylius_product` resource classes with `Tests\Odiseo\SyliusVendorPlugin\Entity\Product` (which implements `VendorAwareInterface`) and a custom `ProductRepository`
- DB credentials go in `tests/TestApplication/.env` (dev) and `.env.test` (test)

### Test Structure
```
tests/
  Unit/          # PHPUnit — pure unit tests, no DB
  Integration/   # PHPUnit — DB-backed (currently empty)
  Functional/    # PHPUnit — full stack (currently empty)
  Behat/
    Context/     # Setup, Transform, UI contexts
    Page/        # Page Object pattern for admin vendor pages
    Behaviour/   # Shared Behat traits/interfaces
    Resources/   # Behat suite config + service definitions
```

### Optional Sitemap Integration
`VendorUrlProvider` implements `SitemapPlugin\Provider\UrlProviderInterface`. It is only wired when `stefandoorn/sitemap-plugin` is installed. See `doc/sitemap.md`.

## AI Development Guides

- **CLEANUP_GUIDE.md** — organizing plugin code
- **RENAME_GUIDE.md** — renaming plugins and components
- **COMPATIBILITY_GUIDE.md** — maintaining compatibility across Sylius versions
