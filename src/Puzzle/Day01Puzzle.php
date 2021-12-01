<?php

namespace PilleAoc2021\Puzzle;

final class Day01Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day01';

    public function solve(): string
    {
        $countIncreases1 = $this->solvePart1();
        $countIncreases2 = $this->solvePart2();

        return sprintf(
            "Measurement increases (part 1): %d\nMeasurement increases (part 2): %d",
            $countIncreases1,
            $countIncreases2
        );
    }

    private function solvePart1(): int
    {
        $inputArray = explode("\n", $this->input);
        $previousMeasurement = false;
        $countIncreases = 0;

        foreach ($inputArray as $depth) {
            if ((int) $depth > $previousMeasurement && $previousMeasurement !== false) {
                $countIncreases++;
            }
            $previousMeasurement = (int) $depth;
        }

        return $countIncreases;
    }

    private function solvePart2(): int
    {
        $inputArray = explode("\n", $this->input);
        $countIncreases = 0;
        $slidingWindows = [];
        $numberOfWindows = count($inputArray) - 2;

        for ($i = 0; $i < $numberOfWindows; $i++) {
            $measurement1 = (int) $inputArray[$i];
            $measurement2 = (int) $inputArray[$i + 1];
            $measurement3 = (int) $inputArray[$i + 2];

            $slidingWindows[$i] = $measurement1 + $measurement2 + $measurement3;
        }

        $previousWindow = false;

        foreach ($slidingWindows as $window) {
            if ($window > $previousWindow && $previousWindow !== false) {
                $countIncreases++;
            }
            $previousWindow = $window;
        }

        return $countIncreases;
    }
}
