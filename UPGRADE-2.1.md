# Upgrade

## From 2.0 to 2.1

### Sylius & Symfony

- The plugin now supports Sylius `2.x` (`sylius/sylius: ^2.0`). Run `composer update` to move to Sylius `2.2.x`.
- On the Symfony `7` line, Sylius 2.2 requires `^7.4`. Dev dependencies were bumped to `^6.4 || ^7.4`.
- PHPSpec was removed from the toolchain; tests are consolidated on PHPUnit.

### BC break: `Vendor` logo property renamed to `logoPath`

The `Vendor` logo property/column/accessors were renamed from `logoName` to `logoPath`
(aligning with Sylius' `path` convention):

| Before | After |
| --- | --- |
| `VendorInterface::getLogoName(): ?string` | `VendorInterface::getLogoPath(): ?string` |
| `VendorInterface::setLogoName(?string): void` | `VendorInterface::setLogoPath(?string): void` |
| column `odiseo_vendor.logo_name` | column `odiseo_vendor.logo_path` |

**What you need to do:**

- Update any code (including downstream plugins) calling `getLogoName()` / `setLogoName()`
  to use `getLogoPath()` / `setLogoPath()`, and any templates using `vendor.logoName`
  to use `vendor.logoPath`.
- Run the database migration that renames the column:

  ```bash
  bin/console doctrine:migrations:migrate
  ```

  (Migration `Odiseo\SyliusVendorPlugin\Migrations\Version20260616120000`.)

### Admin logo validation

The vendor logo is now correctly validated in the admin form: it is required on creation
and, when provided, must be a valid image (JPEG, PNG or WebP, max 2 MB). Previously a
validation-group mismatch meant the "logo required" rule never ran.
