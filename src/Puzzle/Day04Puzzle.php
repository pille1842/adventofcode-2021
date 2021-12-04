<?php

namespace PilleAoc2021\Puzzle;

use PilleAoc2021\Bingo\Board;

final class Day04Puzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'day04';

    public function solve(): string
    {
        $lines = explode("\n", $this->input);
        $draws = array_map(function ($val) {
            return (int) $val;
        }, explode(",", $lines[0]));
        array_shift($lines);
        array_shift($lines);
        $lines = array_values($lines);
        $i = 0;
        $row = 0;
        $board = [];
        $boardContents = [];

        foreach ($lines as $line) {
            if ($line == '') {
                $row = 0;
                $boardContents[] = $board;
                continue;
            }
            $numbers = explode(' ', $line);
            $numbers = array_filter($numbers, function ($val) {
                return trim($val) != '';
            });
            $numbers = array_values($numbers);
            $numbers = array_map(function ($val) {
                return (int) $val;
            }, $numbers);
            $board[$row] = $numbers;
            $i++;
            $row++;
        }

        $boards = [];

        foreach ($boardContents as $boardContent) {
            $board = new Board($boardContent);
            $boards[] = $board;
        }

        $solutionPart1 = $this->findFirstWinner($boards, $draws);
        $solutionPart2 = $this->findLastWinner($boards, $draws);

        return sprintf("Solution to part 1: %d\nSolution to part 2: %d", $solutionPart1, $solutionPart2);
    }

    private function findFirstWinner(array $boards, array $draws): int
    {
        foreach ($draws as $draw) {
            foreach ($boards as $board) {
                $board->mark($draw);
                if ($board->wins()) {
                    return $board->sumUnmarkedNumbers() * $draw;
                }
            }
        }
    }

    private function findLastWinner(array $boards, array $draws): int
    {
        $winners = [];
        foreach ($draws as $draw) {
            foreach ($boards as $i => $board) {
                $board->mark($draw);
                if ($board->wins()) {
                    $winners[] = $board;
                    unset($boards[$i]);
                }
            }

            if (count($boards) == 0) {
                $winner = array_pop($winners);
                return $winner->sumUnmarkedNumbers() * $draw;
            }
        }
    }
}
