<?php

namespace PilleAoc2021\Puzzle;

use Exception;

abstract class AbstractPuzzle implements PuzzleInterface
{
    public static string $puzzleName;
    protected string $input;

    public function getInputFilename(): string
    {
        return static::$puzzleName . '.txt';
    }

    public function setInput(string $input): self
    {
        $this->input = $input;

        return $this;
    }
}
