# Tests

The plugin is tested with **PHPUnit** (unit and functional), **Behat** (UI), **PHPStan** (level max)
and **ECS** (coding standard). A ready-to-use Sylius application lives in `tests/TestApplication`.

## Docker (recommended)

A Docker environment is provided through the `Makefile`:

```bash
make init            # Bootstrap containers + composer install + frontend build
make up / make down  # Start / stop the containers
make php-shell       # Open a shell in the PHP container
make database-init   # Create the database and run migrations
make load-fixtures   # Load Sylius fixtures
```

Then run the test tools:

```bash
make phpunit         # PHPUnit
make behat           # Behat (non-JS scenarios)
make phpstan         # PHPStan
make ecs             # Coding standard
```

## Running the tools directly

If you have PHP and the dependencies available, you can run everything without Docker:

```bash
# PHPUnit — available suites: unit, functional, integration, non-unit, all
vendor/bin/phpunit --testsuite unit
vendor/bin/phpunit --testsuite non-unit
vendor/bin/phpunit                       # everything

# Static analysis & coding standard
vendor/bin/phpstan analyse -c phpstan.neon -l max src/
vendor/bin/ecs check src tests           # add --fix to autofix

# Container linting & composer
vendor/bin/console lint:container
composer validate --strict
```

Database credentials for the test application are configured in `tests/TestApplication/.env` (dev)
and `tests/TestApplication/.env.test` (test).

## Behat

Non-JavaScript scenarios:

```bash
vendor/bin/behat --strict --tags="~@javascript&&~@mink:chromedriver"
```

JavaScript scenarios require headless Chrome and a running server:

```bash
# Start headless Chrome (port 9222) and the test server (port 8080)
APP_ENV=test symfony server:start --port=8080 --daemon

vendor/bin/behat --strict --tags="@javascript,@mink:chromedriver"
```

## Continuous integration

Every push and pull request runs the full suite on GitHub Actions across a matrix of Sylius
(2.0 / 2.1 / 2.2), Symfony (6.4 / 7.4) and PHP (8.2 / 8.3 / 8.4) versions. See
[`.github/workflows/build.yaml`](https://github.com/odiseoteam/SyliusVendorPlugin/blob/master/.github/workflows/build.yaml).
