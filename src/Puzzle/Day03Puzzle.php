<?php

namespace PilleAoc2021\Puzzle;

final class Day03Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day03';

    public function solve(): string
    {
        $solutionPart1 = $this->solvePart1();
        $solutionPart2 = $this->solvePart2();

        return sprintf("Solution to part 1: %d\nSolution to part 2: %d", $solutionPart1, $solutionPart2);
    }

    private function solvePart1(): int
    {
        $numbers = explode("\n", $this->input);
        $inputLength = strlen($numbers[0]);
        $gammaRateBinary = '';
        $epsilonRateBinary = '';

        for ($i = 0; $i < $inputLength; $i++) {
            $countZero = 0;
            $countOne = 0;

            foreach ($numbers as $number) {
                if (substr($number, $i, 1) == '0') {
                    $countZero += 1;
                } else {
                    $countOne += 1;
                }
            }

            if ($countZero > $countOne) {
                $gammaRateBinary .= '0';
                $epsilonRateBinary .= '1';
            } else {
                $gammaRateBinary .= '1';
                $epsilonRateBinary .= '0';
            }
        }

        $gammaRateDecimal = bindec($gammaRateBinary);
        $epsilonRateDecimal = bindec($epsilonRateBinary);

        return $gammaRateDecimal * $epsilonRateDecimal;
    }

    private function solvePart2(): int
    {
        $numbers = explode("\n", $this->input);
        $oxygenGeneratorRatingBinary = $this->findRating($numbers);
        $co2ScrubberRatingBinary = $this->findRating($numbers, true);

        $oxygenGeneratorRatingDecimal = bindec($oxygenGeneratorRatingBinary);
        $co2ScrubberRatingDecimal = bindec($co2ScrubberRatingBinary);

        return $oxygenGeneratorRatingDecimal * $co2ScrubberRatingDecimal;
    }

    private function findRating(array $ratings, bool $inverse = false): string
    {
        $inputLength = strlen($ratings[0]);

        for ($i = 0; $i < $inputLength; $i++) {
            $countZero = 0;
            $countOne = 0;

            foreach ($ratings as $rating) {
                if (substr($rating, $i, 1) == '0') {
                    $countZero++;
                } else {
                    $countOne++;
                }
            }

            if ($countZero > $countOne) {
                $keep = $inverse ? '1' : '0';
            } else {
                $keep = $inverse ? '0' : '1';
            }

            $ratings = array_filter($ratings, function ($val) use ($keep, $i) {
                return substr($val, $i, 1) == $keep;
            });

            if (count($ratings) == 1) {
                return array_values($ratings)[0];
            }
        }
    }
}
