<?php

namespace PilleAoc2021\Command;

use PilleAoc2021\Puzzle\PuzzleInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;

abstract class AbstractCommand extends Command
{
    protected array $puzzleClasses;

    public function __construct()
    {
        parent::__construct();

        $this->discoverPuzzleClasses();
    }

    private function discoverPuzzleClasses(): void
    {
        $finder = new Finder();
        $finder->files()->name('*Puzzle.php')->in(__DIR__ . '/../Puzzle/');

        foreach ($finder as $file) {
            $ns = 'PilleAoc2021\\Puzzle';
            if ($relativePath = $file->getRelativePath()) {
                $ns .= '\\' . strtr($relativePath, '/', '\\');
            }
            $class = $ns . '\\' . $file->getBasename('.php');

            $r = new \ReflectionClass($class);

            if ($r->isSubclassOf('PilleAoc2021\\Puzzle\\PuzzleInterface') && !$r->isAbstract()) {
                $puzzleName = $r->getStaticPropertyValue('puzzleName');
                $this->puzzleClasses[$puzzleName] = $r->getName();
            }
        }
    }

    protected function getPuzzleClassInstance(string $puzzle)
    {
        if (!isset($this->puzzleClasses[$puzzle])) {
            throw new \Exception("Unknown puzzle: $puzzle");
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

    protected function formatError(string $message): string
    {
        $formatter = $this->getHelper('formatter');
        $errorMessages = ['', $message, ''];

        return $formatter->formatBlock($errorMessages, 'error');
    }
}
