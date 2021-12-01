<?php

namespace PilleAoc2021\Command;

use PilleAoc2021\Puzzle\PuzzleInterface;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    protected array $puzzleClasses = [
        'example' => \PilleAoc2021\Puzzle\ExamplePuzzle::class,
    ];

    protected function getPuzzleClassInstance(string $puzzle)
    {
        if (!isset($this->puzzleClasses[$puzzle])) {
            throw new \Exception("Unknown puzzle: $puzzle");
        }

        if ($this->puzzleClasses[$puzzle] === false) {
            throw new \Exception("Puzzle not yet implemented: $puzzle");
        }

        $instance = new $this->puzzleClasses[$puzzle];

        if (!$instance instanceof PuzzleInterface) {
            throw new \Exception("Puzzle does not implement the PuzzleInterface: $puzzle");
        }

        return $instance;
    }

    protected static function getInput($puzzle): string
    {
        $inputFilename = $puzzle->getInputFilename();
        $absolutePath = implode(DIRECTORY_SEPARATOR, [
            dirname(__FILE__),
            '..',
            '..',
            'input',
            $inputFilename
        ]);

        if (!file_exists($absolutePath)) {
            throw new \Exception("File does not exist: $absolutePath");
        }

        if (!is_readable($absolutePath)) {
            throw new \Exception("File is not readable: $absolutePath");
        }

        return file_get_contents($absolutePath);
    }
}
