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

        $skeleton = array_fill(0, 9, 0);
        $fish = array_replace($skeleton, array_count_values($input));

        $solutionPart1 = 0;

        for ($gen = 0; $gen < 256; $gen++) {
            $fish['spawn'] = $fish[0];
            for ($i = 0; $i < 8; $i++) {
                $fish[$i] = $fish[$i + 1];
            }
            $fish[6] += $fish['spawn'];
            $fish[8] = $fish['spawn'];
            if ($gen == 79) {
                $solutionPart1 = array_sum($fish) - $fish['spawn'];
            }
        }

        $fish['spawn'] = 0;
        $solutionPart2 = array_sum($fish);

        return sprintf(
            "# of fish after  80 generations: %d\n# of fish after 256 generations: %d",
            $solutionPart1,
            $solutionPart2
        );
    }
}
