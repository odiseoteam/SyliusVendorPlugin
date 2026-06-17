# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Self-register the plugin's API Platform mapping path, so the Vendor REST API works out of the box
  (admin CRUD + shop read endpoints) without manual `api_platform.mapping.paths` configuration.
- Expose `extraEmails` (vendor additional emails) and `position` on the admin Vendor API resource.
- Multipart logo upload endpoint: `POST /api/v2/admin/vendors/{slug}/logo`, reusing the existing
  `VendorLogoUploader`.
- Translations for 10 additional locales (de, it, pt_BR, nl, pl, ru, ja, zh_CN, tr, ar), on top of
  the existing en/es/fr.
- API functional tests and additional unit tests (logo upload processor, DI extension, product
  fixture/factory/repository trait, configuration).
- Project `CHANGELOG.md`, `CONTRIBUTING.md`, issue and pull request templates.

### Changed
- Admin vendor form reorganised: extra emails moved under the General tab, logo moved to the top of
  the Profile tab, and the now-empty Media tab removed.
- CI matrix extended to test PHP 8.2, 8.3 and 8.4.

### Fixed
- "Add email" button label now resolves to the correct translation key.

## [2.0.0]

See the [GitHub releases](https://github.com/odiseoteam/SyliusVendorPlugin/releases) for the history
of previous versions.

[Unreleased]: https://github.com/odiseoteam/SyliusVendorPlugin/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/odiseoteam/SyliusVendorPlugin/releases/tag/v2.0.0
