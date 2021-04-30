## Usage

For the administration you will have the Vendor menu.
Feel free to modify the plugin templates like you want.

### Partial routes

To render vendor by channel you can do something like this:

```twig
{{ render(url('odiseo_sylius_vendor_plugin_shop_partial_vendor_index_by_channel', {'template': '@OdiseoSyliusVendorPlugin/Shop/Vendor/_vendor.html.twig'})) }}
```

### Form validation group

For forms use the validation group named `odiseo`
