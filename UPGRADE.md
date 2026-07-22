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

### Fix: `sylius_product.vendor_id` is now nullable

The baseline migrations (`Version20211102135222` for MySQL, `Version20211102135223` for
PostgreSQL) previously added `vendor_id` as `NOT NULL` with no backfill. This made the
migration fail on any store that already had products at migration time — including a
plain `sylius:install -s default` demo — with a not-null constraint violation.

`vendor_id` is now nullable, matching the application code (`Product::getVendor(): ?VendorInterface`),
which already treated a missing vendor as a valid state. Products without a vendor simply
don't show a vendor block on the shop product page; the admin product form still requires
selecting one when creating/editing a product there.

**If you haven't successfully run `doctrine:migrations:migrate` yet**, update to this
version first — the migration will now succeed even with existing products.

**If you already hit this error on MySQL**, note that MySQL's `ALTER TABLE` statements
are not transactional, so the migration may have partially applied (the `odiseo_vendor*`
tables created, but the `sylius_product.vendor_id` column/FK missing). Before re-running
`doctrine:migrations:migrate`, check whether those tables already exist
(`SHOW TABLES LIKE 'odiseo_vendor%'`); if so, drop them manually so the migration can
run cleanly from a consistent state. PostgreSQL DDL is transactional, so a failed
migration there rolls back cleanly and can simply be re-run.
