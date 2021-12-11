<?php

namespace PilleAoc2021\Puzzle;

final class Day11Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day11';

    public function solve(): string
    {
        $totalFlashes = 0;
        $totalFlashesAfter100 = 0;
        $stepAllFlash = 0;
        $matrix = [];

        foreach (array_filter(explode("\n", $this->input)) as $line) {
            $matrix[] = array_map('intval', str_split($line));
        }

        $width = count($matrix[0]);
        $height = count($matrix);

        $step = 0;
        while ($stepAllFlash == 0) {
            $step++;
            // First, the energy level of each octopus increases by 1.
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    $matrix[$y][$x] += 1;
                }
            }
            // Then, any octopus with an energy level greater than 9 flashes.
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($matrix[$y][$x] > 9) {
                        $this->flash($matrix, $width, $height, $x, $y);
                    }
                }
            }
            // Finally, any octopus that flashed during this step has its energy level set to 0,
            // as it used all of its energy to flash.
            // Check if all octopus flashed in this step.
            $flashing = 0;
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($matrix[$y][$x] == -1) {
                        $totalFlashes++;
                        $flashing++;
                        $matrix[$y][$x] = 0;
                    }
                }
            }
            if ($flashing == $width * $height && $stepAllFlash == 0) {
                $stepAllFlash = $step;
            }
            if ($step == 100) {
                $totalFlashesAfter100 = $totalFlashes;
            }
        }

        return sprintf(
            "Total flashes after 100 steps: %d\n" .
            "First step during which all octopuses flash: %d",
            $totalFlashesAfter100,
            $stepAllFlash
        );
    }

    private function flash(array &$matrix, int $width, int $height, int $x, int $y)
    {
        $matrix[$y][$x] = -1;
        $adjacent = [];
        // x-1,y
        if ($x > 0) {
            $adjacent[] = [$x - 1, $y];
        }
        // x+1,y
        if ($x < $width - 1) {
            $adjacent[] = [$x + 1, $y];
        }
        // x,y-1
        if ($y > 0) {
            $adjacent[] = [$x, $y - 1];
        }
        // x,y+1
        if ($y < $height - 1) {
            $adjacent[] = [$x, $y + 1];
        }
        // x-1,y-1
        if ($x > 0 && $y > 0) {
            $adjacent[] = [$x - 1, $y - 1];
        }
        // x+1,y-1
        if ($x < $width - 1 && $y > 0) {
            $adjacent[] = [$x + 1, $y - 1];
        }
        // x-1,y+1
        if ($x > 0 && $y < $height - 1) {
            $adjacent[] = [$x - 1, $y + 1];
        }
        // x+1,y+1
        if ($x < $width - 1 && $y < $height - 1) {
            $adjacent[] = [$x + 1, $y + 1];
        }
        foreach ($adjacent as $point) {
            $adjx = $point[0];
            $adjy = $point[1];
            if ($matrix[$adjy][$adjx] != -1) {
                $matrix[$adjy][$adjx] += 1;
                if ($matrix[$adjy][$adjx] > 9) {
                    $this->flash($matrix, $width, $height, $adjx, $adjy);
                }
            }
        }
    }
}
