<?php

namespace PilleAoc2021\Puzzle;

final class Day05Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day05';

    public function solve(): string
    {
        $lines = explode("\n", $this->input);
        $mapPart1 = $this->calculateMap($lines);

        $overlapsPart1 = 0;

        foreach ($mapPart1 as $row) {
            foreach ($row as $point) {
                if ($point > 1) {
                    $overlapsPart1++;
                }
            }
        }

        $mapPart2 = $this->calculateMap($lines, false);

        $overlapsPart2 = 0;

        foreach ($mapPart2 as $row) {
            foreach ($row as $point) {
                if ($point > 1) {
                    $overlapsPart2++;
                }
            }
        }

        return sprintf(
            "# of overlap points (no diagonals): %d\n# of overlap points (with diagonals): %d",
            $overlapsPart1,
            $overlapsPart2
        );
    }

    private function calculateMap(array $lines, bool $ignoreDiagonals = true): array
    {
        $map = [];
        foreach ($lines as $line) {
            if (!preg_match('/(\\d+),(\\d+) -> (\\d+),(\\d+)/', $line, $matches)) {
                continue;
            }
            $x1 = (int) $matches[1];
            $y1 = (int) $matches[2];
            $x2 = (int) $matches[3];
            $y2 = (int) $matches[4];

            if ($x1 != $x2 && $y1 != $y2 && $ignoreDiagonals) {
                continue;
            }

            if ($x1 <= $x2) {
                $xDir = 1;
            } else {
                $xDir = -1;
            }

            if ($y1 <= $y2) {
                $yDir = 1;
            } else {
                $yDir = -1;
            }

            for ($y = $y1; $yDir == 1 ? $y <= $y2 : $y >= $y2; $y+= $yDir) {
                if (!isset($map[$y])) {
                    $map[$y] = [];
                }
                for ($x = $x1; $xDir == 1 ? $x <= $x2 : $x >= $x2; $x+= $xDir) {
                    if ($x1 == $x2 ||
                        $y1 == $y2 ||
                        ($y1 - $y2) * $x + ($x2 - $x1) * $y + ($x1 * $y2 - $x2 * $y1) == 0) {
                        if (!isset($map[$y][$x])) {
                            $map[$y][$x] = 1;
                        } else {
                            $map[$y][$x]++;
                        }
                    }
                }
            }
        }

        return $map;
    }
}
