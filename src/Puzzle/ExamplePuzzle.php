<?php

namespace PilleAoc2021\Puzzle;

final class ExamplePuzzle extends AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName = 'example';

    public function solve(): string
    {
        return trim($this->input);
    }
}
