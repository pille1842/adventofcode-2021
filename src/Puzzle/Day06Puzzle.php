<?php

namespace PilleAoc2021\Puzzle;

final class Day06Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day06';

    public function solve(): string
    {
        $input = array_map(function ($val) {
            return (int) $val;
        }, explode(',', $this->input));

        $fish = array_replace(array_fill(0, 9, 0), array_count_values($input));

        $solutionPart1 = 0;

        for ($gen = 1; $gen <= 256; $gen++) {
            $spawn = $fish[0];
            for ($i = 0; $i < 8; $i++) {
                $fish[$i] = $fish[$i + 1];
            }
            $fish[6] += $spawn;
            $fish[8] = $spawn;
            if ($gen == 80) {
                $solutionPart1 = array_sum($fish);
            }
        }

        $solutionPart2 = array_sum($fish);

        return sprintf(
            "# of fish after  80 days: %d\n# of fish after 256 days: %d",
            $solutionPart1,
            $solutionPart2
        );
    }
}
