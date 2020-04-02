## Fixtures

This plugin comes with fixtures:

### Vendors

Simply add this configuration on your fixture suite:

```yml
# config/packages/_sylius.yaml
sylius_fixtures:
    suites:
        default:
            fixtures:
                vendor:
                    options:
                        random: 3
```
