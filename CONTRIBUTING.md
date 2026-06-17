# Contributing

Thanks for your interest in contributing to the Sylius Vendor Plugin! 🎉

## Getting started

The plugin ships with a Docker-based development environment built around an embedded Sylius test
application.

```bash
make init            # Bootstrap containers + composer install + frontend build
make up / make down  # Start / stop containers
make php-shell       # Shell into the PHP container
```

See `CLAUDE.md` and the `doc/` directory for more details on the architecture.

## Before opening a pull request

Please make sure the full quality suite passes:

```bash
vendor/bin/phpunit --testsuite unit          # Unit tests
vendor/bin/phpunit --testsuite non-unit      # Functional / integration tests
vendor/bin/phpstan analyse -c phpstan.neon -l max src/
vendor/bin/ecs check src tests               # Coding standards (add --fix to autofix)
vendor/bin/console lint:container            # Container linting
composer validate --strict
```

Behat scenarios (UI) can be run with:

```bash
vendor/bin/behat --strict --tags="~@javascript&&~@mink:chromedriver"
```

## Guidelines

- Follow the existing code style; `vendor/bin/ecs check src tests --fix` will handle most of it.
- Keep the public API backward compatible whenever possible; document any breaking change in
  `CHANGELOG.md` under the `[Unreleased]` section.
- Add or update tests for the behaviour you change.
- Translations are welcome — keep the key tree identical across all `translations/*.yaml` files.
- Write clear commit messages and a descriptive pull request body.

## Reporting issues

Use the issue templates and include:

- The plugin, Sylius, PHP and Symfony versions you are running.
- Steps to reproduce, expected behaviour and actual behaviour.

## Security

Please do not open public issues for security vulnerabilities. Instead, contact the maintainers at
[team@odiseo.com.ar](mailto:team@odiseo.com.ar).
