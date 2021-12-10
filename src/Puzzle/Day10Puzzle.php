<?php

namespace PilleAoc2021\Puzzle;

final class Day10Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day10';

    private array $openingBrackets = ['(', '[', '{', '<'];
    private array $closingBrackets = [')', ']', '}', '>'];
    private array $bracketScore = [3, 57, 1197, 25137];

    public function solve(): string
    {
        $lines = array_filter(explode("\n", $this->input));
        $totalScore = 0;
        $middleScores = [];

        foreach ($lines as $line) {
            $stack = [];
            $ignoreLine = false;
            foreach (str_split($line) as $char) {
                if (in_array($char, $this->openingBrackets)) {
                    array_push($stack, $this->closingBrackets[array_search($char, $this->openingBrackets)]);
                } else {
                    $expected = array_pop($stack);
                    if ($char != $expected) {
                        $totalScore += $this->bracketScore[array_search($char, $this->closingBrackets)];
                        $ignoreLine = true;
                        break;
                    }
                }
            }
            if ($ignoreLine) {
                continue;
            }
            if (count($stack) > 0) {
                $add = array_reverse($stack);
                $addScore = 0;
                foreach ($add as $char) {
                    $score = array_search($char, $this->closingBrackets) + 1;
                    $addScore *= 5;
                    $addScore += $score;
                }
                $middleScores[] = $addScore;
            }
        }

        sort($middleScores);
        $middleScore = $middleScores[floor(count($middleScores) / 2)];

        return sprintf(
            "Total syntax error score: %d\n" .
            "Middle score: %d",
            $totalScore,
            $middleScore
        );
    }
}
