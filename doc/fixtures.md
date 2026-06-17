# Fixtures

The plugin ships with a `vendor` fixture and extends the core `product` fixture so products can be
assigned to a vendor.

## Vendor fixture

Add the `vendor` fixture to your suite. The simplest form generates a number of random vendors:

```yaml
# config/packages/_sylius.yaml
sylius_fixtures:
    suites:
        default:
            fixtures:
                vendor:
                    options:
                        random: 3
```

You can also define vendors explicitly with the `custom` option:

```yaml
sylius_fixtures:
    suites:
        default:
            fixtures:
                vendor:
                    options:
                        custom:
                            -
                                name: "Acme"
                                slug: "acme"
                                email: "contact@acme.com"
                                description: "The best brand in town."
                                channels: ["FASHION_WEB"]
                                logo: "%kernel.project_dir%/assets/acme-logo.png"
```

### Available vendor options

| Option | Type | Description |
|---|---|---|
| `name` | string | Vendor name (defaults to a random company name) |
| `slug` | string | Slug (defaults to a slugified name) |
| `email` | string | Primary email (defaults to a random company email) |
| `description` | string | Translatable description (defaults to random text) |
| `channels` | array | Channel codes the vendor belongs to (defaults to random channels) |
| `logo` | string | Path to a logo image file |

## Assigning a vendor to products

The plugin's `product` fixture adds an optional `vendor` option (a vendor slug) on top of the core
product fixture:

```yaml
sylius_fixtures:
    suites:
        default:
            fixtures:
                product:
                    options:
                        custom:
                            -
                                name: "Acme T-Shirt"
                                vendor: "acme"
                                # ...the rest of the core product fixture options
```
