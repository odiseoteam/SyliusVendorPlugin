## Test the plugin

We are using Behat, PHPSpec and PHPUnit to test this plugin.

### How to run the tests

From the plugin root directory, run the following commands:

    ```bash
    $ (cd tests/Application && yarn install)
    $ (cd tests/Application && yarn build)
    $ (cd tests/Application && bin/console assets:install public -e test)

    $ (cd tests/Application && bin/console doctrine:database:create -e test)
    $ (cd tests/Application && bin/console doctrine:schema:create -e test)
    ```

To be able to setup a plugin's database, remember to configure you database credentials in `tests/Application/.env` and `tests/Application/.env.test`.

## Usage

### Running plugin tests

  - PHPUnit

    ```bash
    $ vendor/bin/phpunit
    ```

  - PHPSpec

    ```bash
    $ vendor/bin/phpspec run
    ```

  - Behat (non-JS scenarios)

    ```bash
    $ vendor/bin/behat --strict --tags="~@javascript"
    ```

  - Behat (JS scenarios)

    1. [Install Symfony CLI command](https://symfony.com/download).

    2. Start Headless Chrome:

      ```bash
      $ google-chrome-stable --enable-automation --disable-background-networking --no-default-browser-check --no-first-run --disable-popup-blocking --disable-default-apps --allow-insecure-localhost --disable-translate --disable-extensions --no-sandbox --enable-features=Metal --headless --remote-debugging-port=9222 --window-size=2880,1800 --proxy-server='direct://' --proxy-bypass-list='*' http://127.0.0.1
      ```

    3. Install SSL certificates (only once needed) and run test application's webserver on `127.0.0.1:8080`:

      ```bash
      $ symfony server:ca:install APP_ENV=test symfony server:start --port=8080 --dir=tests/Application/public --daemon
      ```

    4. Run Behat:

      ```bash
      $ vendor/bin/behat --strict --tags="@javascript"
      ```

### Opening Sylius with this plugin

- Using `test` environment:

    ```bash
    $ (cd tests/Application && bin/console sylius:fixtures:load -e test)
    $ (cd tests/Application && bin/console server:run -d public -e test)
    ```

- Using `dev` environment:

    ```bash
    $ (cd tests/Application && bin/console sylius:fixtures:load -e dev)
    $ (cd tests/Application && bin/console server:run -d public -e dev)
    ```
