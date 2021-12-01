<?php

namespace PilleAoc2021\Puzzle;

use Exception;

abstract class AbstractPuzzle implements PuzzleInterface
{
    protected string $input;
    protected string $inputFilename;

    public function getInputFilename(): string
    {
        return $this->inputFilename;
    }

    public function setInput(string $input): self
    {
        $this->input = $input;

        return $this;
    }
}
