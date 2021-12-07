<?php

namespace PilleAoc2021\Puzzle;

final class Day07Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day07';

    public function solve(): string
    {
        $input = array_map(function (string $val) {
            return (int) $val;
        }, explode(',', $this->input));

        [$position1, $fuel1] = $this->solvePart1($input);
        [$position2, $fuel2] = $this->solvePart2($input);

        return sprintf(
            "Part 1: Most fuel-efficient position: %d (fuel expended: %d)\n" .
            "Part 2: Most fuel-efficient position: %d (fuel expended: %d)",
            $position1,
            $fuel1,
            $position2,
            $fuel2
        );
    }

    private function solvePart1(array $crabs): array
    {
        $possiblePositions = range(0, max($crabs));
        $minimumFuel = false;
        $leastExpensivePosition = false;

        foreach ($possiblePositions as $position) {
            $fuelExpended = 0;

            foreach ($crabs as $crab) {
                $fuelExpended += abs($position - $crab);
            }

            if ($leastExpensivePosition === false || $fuelExpended < $minimumFuel) {
                $leastExpensivePosition = $position;
                $minimumFuel = $fuelExpended;
            }
        }

        return [$leastExpensivePosition, $minimumFuel];
    }

    private function solvePart2(array $crabs): array
    {
        $possiblePositions = range(0, max($crabs));
        $minimumFuel = false;
        $leastExpensivePosition = false;

        foreach ($possiblePositions as $position) {
            $fuelExpended = 0;

            foreach ($crabs as $crab) {
                $diff = abs($position - $crab);
                $fuelExpended += ($diff * ($diff + 1)) / 2;
            }

            if ($leastExpensivePosition === false || $fuelExpended < $minimumFuel) {
                $leastExpensivePosition = $position;
                $minimumFuel = $fuelExpended;
            }
        }

        return [$leastExpensivePosition, $minimumFuel];
    }
}
