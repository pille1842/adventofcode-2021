<?php

namespace PilleAoc2021\Puzzle;

final class Day09Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day09';

    public function solve(): string
    {
        $lines = explode("\n", trim($this->input));
        $width = strlen($lines[0]);
        $height = count($lines);

        $map = [];
        foreach ($lines as $line) {
            if (!$line) {
                continue;
            }
            $map[] = array_map(function ($val) {
                return (int) $val;
            }, str_split($line));
        }

        // We'll need the points sorted by altitude later
        $pointsByAltitude = [];
        $lowscore = 0;

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $point = $map[$y][$x];
                $pointsByAltitude[$point][] = [$x, $y];
                $adjacent = array_filter([
                    $y > 0           ? $map[$y - 1][$x] : null,
                    $y < $height - 1 ? $map[$y + 1][$x] : null,
                    $x > 0           ? $map[$y][$x - 1] : null,
                    $x < $width - 1  ? $map[$y][$x + 1] : null,
                ], function ($val) {
                    return $val !== null;
                });
                if ($point < min($adjacent)) {
                    $lowscore += $point + 1;
                }
            }
        }

        // Assigning each point to a basin:
        //   - Create a new matrix and initialize all cells with -1 (unmarked).
        //   - Now iterate over the cells from lowest to highest altitude.
        //   - If the current cell is unmarked, mark it with a new unique ID.
        //   - Mark all its unmarked neighbors with the same ID.
        //   - Finally, count how many times each unique ID occurs in the matrix (omitting all cells with value 9).
        ksort($pointsByAltitude);
        $matrix = array_fill(0, $height, array_fill(0, $width, -1));
        $autoincrement = 0;

        foreach ($pointsByAltitude as $altitude => $points) {
            foreach ($points as $point) {
                $x = $point[0];
                $y = $point[1];
                if ($matrix[$y][$x] == -1) {
                    $id = $autoincrement;
                    $autoincrement++;
                } else {
                    $id = $matrix[$y][$x];
                }
                if ($y > 0 && $matrix[$y - 1][$x] == -1) {
                    $matrix[$y - 1][$x] = $id;
                }
                if ($y < $height - 1 && $matrix[$y + 1][$x] == -1) {
                    $matrix[$y + 1][$x] = $id;
                }
                if ($x > 0 && $matrix[$y][$x - 1] == -1) {
                    $matrix[$y][$x - 1] = $id;
                }
                if ($x < $width - 1 && $matrix[$y][$x + 1] == -1) {
                    $matrix[$y][$x + 1] = $id;
                }
            }
        }

        $basins = array_fill(0, $autoincrement, 0);

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $point = $map[$y][$x];
                if ($point < 9) {
                    $id = $matrix[$y][$x];
                    $basins[$id] += 1;
                }
            }
        }

        sort($basins);

        while (count($basins) > 3) {
            unset($basins[array_search(min($basins), $basins)]);
        }

        $basinsProduct = array_product($basins);

        return sprintf(
            "Sum of risk levels of all low points: %d\n" .
            "Product of the three largest basins:  %d",
            $lowscore,
            $basinsProduct
        );
    }
}
