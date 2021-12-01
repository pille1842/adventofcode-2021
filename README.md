# Advent of Code 2021

These are my solutions for [Advent of Code 2021](https://adventofcode.com/2021/). The solutions in this repository
are written in PHP.

## Setup

To run these solutions locally, you'll need PHP >= 7.4 and [Composer](https://getcomposer.org/). First step is to
clone the repository:

```
$ git clone https://github.com/pille1842/adventofcode-2021 && cd adventofcode-2021
```

Next, install the project dependencies with Composer:

```
$ composer install
```

## Input files

My input files are located in the `input/` directory. To use your own input files, replace the files in this
directory with your own versions.

## Running puzzles

All interaction is through the command-line interface. To get an overview of available commands, run:

```
$ php aoc.php
```

To list all available puzzles, run:

```
$ php aoc.php puzzles
```

To solve a specific puzzle, run:

```
$ php aoc.php solve name-of-puzzle
```

To create a scaffolding puzzle class for a given day and fetch its input file automatically, run:

```
$ php aoc.php make $DAY
```

## License

The work in this repository is licensed under the MIT license. A copy can be found in the file LICENSE.
