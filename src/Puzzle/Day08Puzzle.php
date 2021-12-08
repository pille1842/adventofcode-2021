<?php

namespace PilleAoc2021\Puzzle;

final class Day08Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day08';

    public function solve(): string
    {
        $countUniqueDigits = $this->solvePart1();
        $entrySum = $this->solvePart2();

        return sprintf(
            "Digits 1, 4, 7, or 8 appear %d times in the output values.\n" .
            "The sum of all output values is %d.",
            $countUniqueDigits,
            $entrySum
        );
    }

    private function solvePart1(): int
    {
        $countUniqueDigits = 0;
        $lines = explode("\n", trim($this->input));
        foreach ($lines as $line) {
            $outputValues = explode(' ', trim(explode('|', $line)[1]));
            foreach ($outputValues as $value) {
                $length = strlen($value);
                if ($length == 7 || $length == 4 || $length == 3 || $length == 2) {
                    $countUniqueDigits++;
                }
            }
        }

        return $countUniqueDigits;
    }

    private function solvePart2(): int
    {
        $entrySum = 0;
        $lines = explode("\n", trim($this->input));
        foreach ($lines as $line) {
            [$patterns, $values] = explode(' | ', $line);
            $matrix = array_flip($this->decodePatterns(explode(' ', $patterns)));
            
            $solution = '';
            foreach (explode(' ', $values) as $digit) {
                $digit = $this->strsort($digit);
                $solution .= $matrix[$digit];
            }
            $entrySum += (int) $solution;
        }

        return $entrySum;
    }

    private function decodePatterns($patterns): array
    {
        $matrix = [];

        $patterns = array_map(function ($pattern) {
            $strParts = str_split($pattern);
            return implode('', $strParts);
        }, $patterns);
        
        foreach ($patterns as $pattern) {
            switch (strlen($pattern)) {
                case 2:
                    $matrix[1] = $pattern;
                    break;
                case 4:
                    $matrix[4] = $pattern;
                    break;
                case 3:
                    $matrix[7] = $pattern;
                    break;
                case 7:
                    $matrix[8] = $pattern;
                    break;
            }
        }

        /*
         * Segments:
         *
         *   0000
         *  5    1
         *  5    1
         *   6666
         *  4    2
         *  4    2
         *   3333
         */
        $segments = array_fill(0, 7, null);
        // Top bar is the difference between 7 and 1
        $segments[0] = $this->difference($matrix[7], $matrix[1]);
        // 6 is length 6, but doesn't have the right side fully lit up
        foreach ($patterns as $pattern) {
            if (strlen($pattern) == 6 && $this->containsNFrom($pattern, $matrix[1], 1)) {
                $matrix[6] = $pattern;
            }
        }
        // 5 is 6 with one less element
        foreach ($patterns as $pattern) {
            if (strlen($pattern) == 5 && $this->containsNFrom($pattern, $matrix[6], 5)) {
                $matrix[5] = $pattern;
                // bottom left is difference between 6 and 5
                $segments[4] = $this->difference($matrix[6], $pattern);
            }
        }
        // 0 is 8 minus middle bar including 1
        foreach ($patterns as $pattern) {
            if (strlen($pattern) == 6 &&
                $this->containsNFrom($pattern, $matrix[8], 6) &&
                $this->containsNFrom($pattern, $matrix[1], 2) &&
                str_contains($pattern, $segments[4]) &&
                !in_array($pattern, $matrix)) {
                $matrix[0] = $pattern;
                // ... so set the middle bar
                $segments[6] = $this->difference($matrix[8], $pattern);
            }
        }
        // top left is 4 minus 1 minus middle bar
        $fourminusone = $this->difference($matrix[4], $matrix[1]);
        $segments[5] = $this->difference($fourminusone, $segments[6]);
        // top right is 8 minus 6
        $segments[1] = $this->difference($matrix[8], $matrix[6]);
        // bottom right is difference between top right and 1
        $segments[2] = $this->difference($matrix[1], $segments[1]);
        // bottom bar is what's left
        $segments[3] = $this->difference($matrix[8], implode('', $segments));
        // 2 is segments 0, 1, 6, 4, 3
        $matrix[2] = $this->strsort($segments[0] . $segments[1] . $segments[6] . $segments[4] . $segments[3]);
        // 9 is 8 minus bottom left
        $matrix[9] = $this->difference($matrix[8], $segments[4]);
        // 3 is segments 0, 1, 6, 2, 3
        $matrix[3] = $this->strsort($segments[0] . $segments[1] . $segments[6] . $segments[2] . $segments[3]);

        $matrix = array_map(function ($pattern) {
            return $this->strsort($pattern);
        }, $matrix);

        return $matrix;
    }

    private function containsNFrom($haystack, $needle, $n): bool
    {
        $count = 0;
        foreach (str_split($needle) as $char) {
            if (str_contains($haystack, $char)) {
                $count++;
            }
        }
        return $count == $n;
    }

    private function difference($a, $b): string
    {
        $diff = '';
        for ($i = 0; $i < strlen($a); $i++) {
            if (!str_contains($b, substr($a, $i, 1))) {
                $diff .= substr($a, $i, 1);
            }
        }
        return $diff;
    }

    private function sum($a, $b): string
    {
        $arr1 = str_split($a);
        $arr2 = str_split($b);

        return implode('', array_unique(array_merge($arr1, $arr2)));
    }

    private function strsort($str): string
    {
        $arr = str_split($str);
        sort($arr);
        return implode('', $arr);
    }
}
