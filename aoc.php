#!/usr/bin/env php
<?php

use Commando\Command;

require_once 'vendor/autoload.php';

if (php_sapi_name() !== "cli") {
    die("This script is intended for use on the command-line interface.");
}

$puzzles = [
    'day01' => false,
    'day02' => false,
    'day03' => false,
    'day04' => false,
    'day05' => false,
    'day06' => false,
    'day07' => false,
    'day08' => false,
    'day09' => false,
    'day10' => false,
    'day11' => false,
    'day12' => false,
    'day13' => false,
    'day14' => false,
    'day15' => false,
    'day16' => false,
    'day17' => false,
    'day18' => false,
    'day19' => false,
    'day20' => false,
    'day21' => false,
    'day22' => false,
    'day23' => false,
    'day24' => false,
    'day25' => false,
    'example' => PilleAoc2021\Puzzle\ExamplePuzzle::class,
];

$solveCmd = new Command();

$solveCmd->option()
    ->referToAs('puzzle')
    ->must(function ($puzzle) use ($puzzles) {
        return isset($puzzles[$puzzle]);
    })
    ->map(function ($puzzle) use ($puzzles) {
        if (array_key_exists($puzzle, $puzzles)) {
            if ($puzzles[$puzzle] !== false) {
                return new $puzzles[$puzzle];
            } else {
                throw new Exception("Puzzle $puzzle has not been implemented yet.");
            }
        }
    })
    ->describedAs('Puzzle to solve. If none is given, a list of puzzles is displayed.');

if ($solveCmd[0]) {
    $puzzle = $solveCmd[0];
    try {
        echo $puzzle->readInput()->solve() . PHP_EOL;
    } catch (Exception $e) {
        $color = new \Colors\Color();
        $error = $color("An error occurred while solving the puzzle:")->white()->bg('red')->bold();
        $error .= ' ' . $e->getMessage();
        fwrite(STDERR, $error . PHP_EOL);
    }
} else {
    $color = new \Colors\Color();
    echo $color(\Commando\Util\Terminal::header(' List of puzzles'))
            ->white()->bg('green')->bold() . PHP_EOL . PHP_EOL;
    foreach ($puzzles as $puzzleName => $puzzleClass) {
        echo $puzzleName . " ";
        if ($puzzleClass === false) {
            $color = new \Colors\Color();
            echo $color("(not implemented yet)")->black()->bg('yellow')->bold();
        }
        echo PHP_EOL;
    }
}
