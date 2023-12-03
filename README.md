![advent-of-code-2023](./advent-of-code-2023-hero.png)

My attempts at the [Advent of Code 2023](https://adventofcode.com/2023) challenges in [PHP](https://www.php.net).

## Solutions

| Day | Name           | Code                             | Input Data                         | Time †      | GitHub Action Output                                                                                                                                                                                                      |
|-----|----------------|----------------------------------|------------------------------------|-------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 01  | Trebuchet?!    | [src/Day01.php](./src/Day01.php) | [src/Day01.data](./src/Day01.data) | `0.002655s` | [![Day-01](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-01.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-01.yml?query=branch%3Amain) |
| 02  | Cube Conundrum | [src/Day02.php](./src/Day02.php) | [src/Day02.data](./src/Day02.data) | `0.001402s` | [![Day-02](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-02.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-02.yml?query=branch%3Amain) |
| 03  | Gear Ratios    | [src/Day03.php](./src/Day03.php) | [src/Day03.data](./src/Day03.data) | `0.006805s` | [![Day-03](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-03.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-03.yml?query=branch%3Amain) |

<!--
| 04  |  | [src/Day04.php](./src/Day04.php) | [src/Day04.data](./src/Day04.data) | `` | [![Day-04](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-04.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-04.yml?query=branch%3Amain) |
| 05  |  | [src/Day05.php](./src/Day05.php) | [src/Day05.data](./src/Day05.data) | `` | [![Day-05](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-05.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-05.yml?query=branch%3Amain) |
| 06  |  | [src/Day06.php](./src/Day06.php) | [src/Day06.data](./src/Day06.data) | `` | [![Day-06](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-06.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-06.yml?query=branch%3Amain) |
| 07  |  | [src/Day07.php](./src/Day07.php) | [src/Day07.data](./src/Day07.data) | `` | [![Day-07](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-07.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-07.yml?query=branch%3Amain) |
| 08  |  | [src/Day08.php](./src/Day08.php) | [src/Day08.data](./src/Day08.data) | `` | [![Day-08](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-08.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-08.yml?query=branch%3Amain) |
| 09  |  | [src/Day09.php](./src/Day09.php) | [src/Day09.data](./src/Day09.data) | `` | [![Day-09](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-09.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-09.yml?query=branch%3Amain) |
| 10  |  | [src/Day10.php](./src/Day10.php) | [src/Day10.data](./src/Day10.data) | `` | [![Day-10](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-10.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-10.yml?query=branch%3Amain) |
| 11  |  | [src/Day11.php](./src/Day11.php) | [src/Day11.data](./src/Day11.data) | `` | [![Day-11](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-11.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-11.yml?query=branch%3Amain) |
| 12  |  | [src/Day12.php](./src/Day12.php) | [src/Day12.data](./src/Day12.data) | `` | [![Day-12](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-12.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-12.yml?query=branch%3Amain) |
| 13  |  | [src/Day13.php](./src/Day13.php) | [src/Day13.data](./src/Day13.data) | `` | [![Day-13](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-13.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-13.yml?query=branch%3Amain) |
| 14  |  | [src/Day14.php](./src/Day14.php) | [src/Day14.data](./src/Day14.data) | `` | [![Day-14](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-14.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-14.yml?query=branch%3Amain) |
| 15  |  | [src/Day15.php](./src/Day15.php) | [src/Day15.data](./src/Day15.data) | `` | [![Day-15](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-15.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-15.yml?query=branch%3Amain) |
| 16  |  | [src/Day16.php](./src/Day16.php) | [src/Day16.data](./src/Day16.data) | `` | [![Day-16](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-16.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-16.yml?query=branch%3Amain) |
| 17  |  | [src/Day17.php](./src/Day17.php) | [src/Day17.data](./src/Day17.data) | `` | [![Day-17](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-17.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-17.yml?query=branch%3Amain) |
| 18  |  | [src/Day18.php](./src/Day18.php) | [src/Day18.data](./src/Day18.data) | `` | [![Day-18](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-18.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-18.yml?query=branch%3Amain) |
| 19  |  | [src/Day19.php](./src/Day19.php) | [src/Day19.data](./src/Day19.data) | `` | [![Day-19](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-19.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-19.yml?query=branch%3Amain) |
| 20  |  | [src/Day20.php](./src/Day20.php) | [src/Day20.data](./src/Day20.data) | `` | [![Day-20](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-20.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-20.yml?query=branch%3Amain) |
| 21  |  | [src/Day21.php](./src/Day21.php) | [src/Day21.data](./src/Day21.data) | `` | [![Day-21](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-21.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-21.yml?query=branch%3Amain) |
| 22  |  | [src/Day22.php](./src/Day22.php) | [src/Day22.data](./src/Day22.data) | `` | [![Day-22](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-22.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-22.yml?query=branch%3Amain) |
| 23  |  | [src/Day23.php](./src/Day23.php) | [src/Day23.data](./src/Day23.data) | `` | [![Day-23](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-23.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-23.yml?query=branch%3Amain) |
| 24  |  | [src/Day24.php](./src/Day24.php) | [src/Day24.data](./src/Day24.data) | `` | [![Day-24](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-24.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-24.yml?query=branch%3Amain) |
| 25  |  | [src/Day25.php](./src/Day25.php) | [src/Day25.data](./src/Day25.data) | `` | [![Day-25](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-25.yml/badge.svg?branch=main)](https://github.com/leifgehrmann/advent-of-code-2023/actions/workflows/Day-25.yml?query=branch%3Amain) |
-->

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
