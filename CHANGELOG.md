# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.1.1] - 2026-07-20

### Fixed
- Migrations no longer fail on PostgreSQL. The three existing migrations hardcoded MySQL-only DDL
  (`AUTO_INCREMENT`, `ENGINE = InnoDB`, backtick-quoted collations, `CHANGE` column syntax), which
  made the plugin uninstallable on Postgres — Sylius 2.x's other officially supported database.
  Each MySQL migration now has a PostgreSQL sibling (following the same paired-migration pattern
  used by `sylius/sylius` core), gated via `Sylius\Bundle\CoreBundle\Doctrine\Migrations\AbstractMigration`
  / `AbstractPostgreSQLMigration` so the right one runs automatically depending on the connected
  platform.

## [2.1.0] - 2026-06-17

### Added
- Sylius 2.2 support (the plugin now supports Sylius 2.0, 2.1 and 2.2).
- The plugin self-registers its API Platform mapping, so the Vendor REST API works out of the box —
  admin CRUD (`/api/v2/admin/vendors`) and shop read endpoints (`/api/v2/shop/vendors`) — with no
  manual `api_platform.mapping.paths` configuration.
- `extraEmails` (vendor additional emails, as an embedded writable collection) and `position`
  exposed on the admin Vendor API resource.
- Multipart logo upload endpoint: `POST /api/v2/admin/vendors/{slug}/logo`, reusing the existing
  `VendorLogoUploader`.
- Optional sitemap integration through `VendorUrlProvider` (for `stefandoorn/sitemap-plugin`).
- Translations for 10 additional locales (de, it, pt_BR, nl, pl, ru, ja, zh_CN, tr, ar), on top of
  the existing en/es/fr.
- API functional tests and additional unit tests (logo upload processor, DI extension, product
  fixture/factory/repository trait, configuration).
- `CHANGELOG.md`, `CONTRIBUTING.md`, issue and pull request templates, and `doc/api.md`.

### Changed
- Renamed the vendor logo property `logoName` → `logoPath` on `Vendor` and `VendorInterface`
  (and `VendorLogoUploader`), with a migration renaming the `odiseo_vendor.logo_name` column to
  `logo_path`. **Upgrade note:** update any code calling `getLogoName()` / `setLogoName()` and run
  `bin/console doctrine:migrations:migrate`.
- Admin vendor form reorganised: extra emails moved under the General tab, the logo moved to the top
  of the Profile tab, and the now-empty Media tab removed.
- CI matrix extended to test PHP 8.2, 8.3 and 8.4, with workflow setup and concurrency improvements.

### Removed
- Dead `VendorFormMenuBuilderEvent` class and its unused service definition.

### Fixed
- "Add email" button label now resolves to the correct translation key.

## [2.0.0]

See the [GitHub releases](https://github.com/odiseoteam/SyliusVendorPlugin/releases) for the history
of previous versions.

[Unreleased]: https://github.com/odiseoteam/SyliusVendorPlugin/compare/v2.1.1...HEAD
[2.1.1]: https://github.com/odiseoteam/SyliusVendorPlugin/compare/v2.1.0...v2.1.1
[2.1.0]: https://github.com/odiseoteam/SyliusVendorPlugin/compare/v2.0.0...v2.1.0
[2.0.0]: https://github.com/odiseoteam/SyliusVendorPlugin/releases/tag/v2.0.0
