# Customization

## Overriding models and resources

The vendor and vendor email models are registered as Sylius resources in
[`config/app/resources/vendor.yaml`](https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/config/app/resources/vendor.yaml)
and
[`config/app/resources/vendor_email.yaml`](https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/config/app/resources/vendor_email.yaml).

To override a class (model, repository, factory or form), redefine the relevant part of the
`sylius_resource` configuration in your application. For example, to use your own `Vendor` model:

```yaml
# config/packages/_sylius.yaml
sylius_resource:
    resources:
        odiseo_vendor.vendor:
            classes:
                model: App\Entity\Vendor\Vendor
```

Your model should extend `Odiseo\SyliusVendorPlugin\Entity\Vendor` (or implement
`Odiseo\SyliusVendorPlugin\Entity\VendorInterface`).

## Overriding templates

The admin and shop views are composed with [Sylius Twig Hooks](https://stack.sylius.com/). You can
override the plugin templates by placing your own versions under
`templates/bundles/OdiseoSyliusVendorPlugin/`, or reconfigure the hooks defined in
`config/app/twig_hooks/` from your application to add, replace or remove parts of a view.

## Overriding the form

The vendor admin form is `Odiseo\SyliusVendorPlugin\Form\Type\VendorType`. To customize it, create a
[form extension](https://symfony.com/doc/current/form/create_form_type_extension.html) for that type,
or override the `odiseo_vendor.vendor` resource `form` class.

## Extending the `Product` relationship

The product ↔ vendor link is provided by `VendorAwareInterface` / `VendorTrait` and
`ProductRepositoryTrait` (see the [installation guide](installation.md)). You can build on top of
these in your own product entity and repository.
