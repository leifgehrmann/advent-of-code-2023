![advent-of-code-2023](./advent-of-code-2023-hero.png)

My attempts at the [Advent of Code 2023](https://adventofcode.com/2023) challenges in [PHP](https://www.php.net).

## Solutions

| Day | Name           | Code                             | Time †      |
|-----|----------------|----------------------------------|-------------|
| 01  | Trebuchet?!    | [src/Day01.php](./src/Day01.php) | `0.002655s` |
| 02  | Cube Conundrum | [src/Day02.php](./src/Day02.php) | `0.001402s` |
| 03  | Gear Ratios    | [src/Day03.php](./src/Day03.php) | `0.006805s` |
| 04  | Scratchcards   | [src/Day04.php](./src/Day04.php) | `0.006466s` |

† The measured execution time in GitHub Actions

## Installation

### Installing on your machine

Installation with vary on each system. For a full environment the following dependencies should be installed:

* [PHP](https://www.php.net) 8.3
* [Composer](https://getcomposer.org) 2.6
* [Xdebug](https://xdebug.org) 3.3

### Installing with Docker

Using [Docker](https://www.docker.com/get-started/) avoids the complexity of installing the dependencies listed above.

Once Docker is installed, a Docker image can be built by running:

```shell
make docker-build
```

Once built, an interactive shell with the project directory mounted can be started by running: 

```shell
make shell
```

## How to run

Before running the code, the PHP dependencies must be installed by running:

```shell
composer install
```

All puzzles can be executed by running:

```shell
php src/main.php
```

Individual puzzles can be executed by adding the day-number:

```shell
php src/main.php 01
```

The solutions can be benchmarked by adding the flag `-b`:

```shell
php src/main.php 01 -b
```

## How to develop

As mentioned above, the code for each puzzle can be run individually. But this project has additional tools to help with development.

### Tests

Test-driven-development using unit tests can help with solving a puzzle by ensuring individual functions work as expected. Tests can be added in `tests/Unit/*` and run using [PHPUnit](http://phpunit.de). The flags `--testdox` and `--colors` can help make the output more legible:

```shell
vendor/bin/phpunit tests/Unit/Day01Test.php --testdox --colors
```

This can be run quickly for all tests from the Makefile:

```shell
make tests
```

### Linting & Static Analysis

Following code standards can help make the code more legible and running static analysis tools can spot issues in the code. This project comes with PHP [CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and [Psalm](https://psalm.dev):

```shell
vendor/bin/phpcs -p --standard=PSR12 src/ tests/
vendor/bin/psalm --show-info=true
```

These can be run quickly from the Makefile:

```shell
make lint
```

## Attribution

* Hero background image by [Eugene Golovesov](https://unsplash.com/photos/a-turtle-in-a-christmas-tree-28d-4waQm3M) on [Unsplash](https://unsplash.com/).
