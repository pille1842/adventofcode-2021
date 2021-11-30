<?php

namespace PilleAoc2021\Puzzle;

final class ExamplePuzzle extends AbstractPuzzle implements PuzzleInterface
{
    protected string $inputFilename = 'example.txt';

    public function solve(): string
    {
        return trim($this->input);
    }
}
