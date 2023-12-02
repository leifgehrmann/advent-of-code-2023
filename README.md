![advent-of-code-2023](./advent-of-code-2023-hero.png)

My attempts at the [Advent of Code 2023](https://adventofcode.com/2023) challenges in [PHP](https://www.php.net).

## Solutions

| Day | Name            | Code                             | Input Data                         | Time †      | GitHub Action Output                                                                                                                                                                                                      |
|-----|-----------------|----------------------------------|------------------------------------|-------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 01  | Trebuchet?!     | [src/Day01.php](./src/Day01.php) | [src/Day01.data](./src/Day01.data) | `0.002655s` | [![Day-01](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-01.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-01.yml?query=branch%3Amain) |
| 02  | Cube Conundrum  | [src/Day02.php](./src/Day02.php) | [src/Day02.data](./src/Day02.data) | `0.001402s` | [![Day-02](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-02.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-02.yml?query=branch%3Amain) |

† The measured execution time in GitHub Actions

## How to run

The puzzles can be run by either installing PHP and [Composer](https://getcomposer.org) directly on your machine, or using [Docker](https://www.docker.com/get-started/). Assuming Docker is installed, run `make shell` to run an interactive shell with Composer installed:

Before running the code, the dependencies must be installed by running:

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
