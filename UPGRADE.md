# Upgrade

> Upgrading from an older release? See [UPGRADE-2.1.md](UPGRADE-2.1.md) for the 2.0 → 2.1 notes.

## From 2.1 to 2.2

### Fixed: migrations now work on PostgreSQL

The baseline migrations hardcoded MySQL-only DDL (`AUTO_INCREMENT`, `ENGINE = InnoDB`,
backtick-quoted collations, `CHANGE` column syntax), which made the plugin uninstallable
on PostgreSQL. Each MySQL migration now has a PostgreSQL sibling, so
`bin/console doctrine:migrations:migrate` runs the right one automatically depending on
the connected platform. No action needed beyond running the migration.

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
