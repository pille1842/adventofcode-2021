<?php

namespace PilleAoc2021\Puzzle;

use Exception;

abstract class AbstractPuzzle implements PuzzleInterface
{
    protected string $input;
    protected string $inputFilename;

    public function readInput(): self
    {
        $localFilename = dirname(__FILE__) .
            DIRECTORY_SEPARATOR .
            '..' .
            DIRECTORY_SEPARATOR .
            '..' .
            DIRECTORY_SEPARATOR .
            'input' .
            DIRECTORY_SEPARATOR .
            $this->inputFilename;

        $realFilename = realpath($localFilename);

        if ($realFilename === false) {
            throw new Exception("I/O error while trying to find $localFilename. Does the file exist?");
        }

        $this->input = file_get_contents($realFilename);

        return $this;
    }
}
