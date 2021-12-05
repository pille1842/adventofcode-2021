<?php

namespace PilleAoc2021\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SolvePuzzleCommand extends AbstractCommand
{
    protected static $defaultName = 'solve';
    protected static $defaultDescription = 'Solve the given puzzle';

    protected function configure(): void
    {
        $this
            ->setHelp('Solve the given puzzle and print the solution to stdout')
            ->addArgument('puzzle', InputArgument::REQUIRED, 'Puzzle to solve')
            ->addArgument('input', InputArgument::OPTIONAL, 'Input file to use')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $beforeTime = microtime(true);

            $puzzle = $this->getPuzzleClassInstance($input->getArgument('puzzle'));
            $input = self::getInput($puzzle, $input->getArgument('input'));
            $puzzle->setInput($input);
            $solution = $puzzle->solve();

            $output->writeln($solution);

            $afterTime = microtime(true);
            $duration = $afterTime - $beforeTime;
            $output->writeln(sprintf("<info>Total execution time: %fs</info>", $duration));
        } catch (\Exception $e) {
            $formattedError = $this->formatError($e->getMessage());
            $output->writeln("\n" . $formattedError . "\n");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
