# Compatibility With Sylius Guide for AI

This guide explains how to configure the Plugin to work with different versions of Sylius (1.14, 2.0, and 2.1).

## Supported Sylius Versions

- Sylius 1.14.x
- Sylius 2.0.x  
- Sylius 2.1.x

## Key Compatibility Changes

### 1. Composer Configuration

To support multiple Sylius versions, update your `composer.json`:

```json
{
    "require": {
        "php": "^8.1",
        "sylius/sylius": "^1.14 || ^2.0 || ^2.1"
    },
    "require-dev": {
        "sylius/sylius-rector": "^1.14 || ^2.0",
        "sylius/test-application": "^1.14.0@alpha || ^2.0.0@alpha || ^2.1.0@alpha",
        "symfony/webpack-encore-bundle": "^1.15 || ^2.2"
    },
    "prefer-stable": true
}
```

**Important notes:**
- PHP 8.1 is the minimum requirement for cross-version compatibility
- Use `prefer-stable: true` to prefer stable packages when available
- Use version constraints with `||` operator to support multiple versions

#### For Sylius 2.0 and 2.1:

In Sylius 2.0+, these properties are provided by the parent class, so you can use them directly without initialization.

### 2. Testing Across Versions

To test your plugin with different Sylius versions:

1. **Update composer.json for specific version:**
   ```bash
   # For Sylius 1.14
   composer require "sylius/sylius:~1.14.0"
   
   # For Sylius 2.0
   composer require "sylius/sylius:~2.0.0"
   
   # For Sylius 2.1
   composer require "sylius/sylius:~2.1.0"
   ```

2. **Run tests:**
   ```bash
   vendor/bin/phpunit
   vendor/bin/phpspec run
   vendor/bin/behat
   ```

## Best Practices

1. **Use Conservative Constraints**: When supporting multiple versions, use the most conservative approach that works across all versions.

2. **Test Thoroughly**: Always test your plugin with each supported Sylius version before release.

3. **Document Version-Specific Features**: If certain features only work with specific Sylius versions, document this clearly.

4. **Use CI/CD**: Set up GitHub Actions or other CI tools to test against all supported versions automatically.

## Troubleshooting

### Common Issues

1. **Service not found errors**: Check that service IDs haven't changed between versions.

2. **Namespace conflicts**: Use fully qualified class names when there's ambiguity.

3. **Dependency conflicts**: Use `composer why-not` to debug version constraint issues.

## Conclusion

By following this guide, your plugin should work seamlessly across Sylius 1.14, 2.0, and 2.1. The key is understanding the differences between versions and implementing conditional logic where necessary while maintaining a clean, maintainable codebase.
