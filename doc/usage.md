# Usage

## Administration

Once installed, a **Vendors** entry is added to the admin menu. From there you can create, edit and
delete vendors, including their:

- name, slug, primary email and enabled state;
- channels;
- translatable description;
- logo;
- extra emails.

## Shop routes

The plugin registers two shop routes (under the prefix configured during installation):

| Route name | Path | Description |
|---|---|---|
| `odiseo_vendor_shop_vendor_index` | `/{_locale}/vendors/` | Paginated, channel-aware vendor list |
| `odiseo_vendor_shop_vendor_show` | `/{_locale}/vendors/{slug}` | A single vendor and its products |

Link to a vendor from a template with:

```twig
<a href="{{ path('odiseo_vendor_shop_vendor_show', { slug: vendor.slug }) }}">
    {{ vendor.name }}
</a>
```

## Fetching a vendor in Twig

The plugin exposes a Twig function to fetch a vendor by its slug (using the current locale by
default):

```twig
{% set vendor = odiseo_vendor_get_vendor_by_slug('my-vendor-slug') %}

{% if vendor %}
    <h2>{{ vendor.name }}</h2>
    <p>{{ vendor.description }}</p>
{% endif %}

{# Optionally force a locale #}
{% set vendor = odiseo_vendor_get_vendor_by_slug('my-vendor-slug', 'en_US') %}
```

## Product ↔ vendor relationship

Once the `Product` entity is vendor-aware (see the [installation guide](installation.md)), you can
read and set its vendor:

```php
$product->getVendor();          // ?VendorInterface
$product->setVendor($vendor);
```

And from a vendor you can access its products:

```php
$vendor->getProducts();         // Collection<ProductInterface>
```

## Form validation group

When building or extending vendor forms, use the validation group named `odiseo`.

## Customizing templates

The shop and admin views are built with [Sylius Twig Hooks](https://stack.sylius.com/) and Twig
components. You can override any template or hook configuration from your application. See the
[customization guide](customization.md).
