<?php

namespace PilleAoc2021\Puzzle;

final class Day02Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day02';

    public function solve(): string
    {
        $solutionPart1 = $this->solvePart1();
        $solutionPart2 = $this->solvePart2();

        return sprintf("Solution to part 1: %d\nSolution to part 2: %d", $solutionPart1, $solutionPart2);
    }

    private function solvePart1(): int
    {
        $instructions = explode("\n", $this->input);
        $horizontalPosition = 0;
        $depth = 0;
        $line = 1;

        foreach ($instructions as $instruction) {
            if (!$instruction) {
                continue;
            }

            $parts = explode(" ", $instruction);
            $direction = $parts[0];
            $magnitude = (int) $parts[1];

            switch ($direction) {
                case 'forward':
                    $horizontalPosition += $magnitude;
                    break;
                case 'up':
                    $depth -= $magnitude;
                    break;
                case 'down':
                    $depth += $magnitude;
                    break;
                default:
                    throw new \Exception("Unknown instruction in line $line: $instruction");
            }

            $line++;
        }

        return $horizontalPosition * $depth;
    }

    private function solvePart2(): int
    {
        $instructions = explode("\n", $this->input);
        $horizontalPosition = 0;
        $depth = 0;
        $aim = 0;
        $line = 1;

        foreach ($instructions as $instruction) {
            if (!$instruction) {
                continue;
            }

            $parts = explode(" ", $instruction);
            $direction = $parts[0];
            $magnitude = (int) $parts[1];

            switch ($direction) {
                case 'forward':
                    $horizontalPosition += $magnitude;
                    $depth += $aim * $magnitude;
                    break;
                case 'up':
                    $aim -= $magnitude;
                    break;
                case 'down':
                    $aim += $magnitude;
                    break;
                default:
                    throw new \Exception("Unknown instruction in line $line: $instruction");
            }

            $line++;
        }

        return $horizontalPosition * $depth;
    }
}
