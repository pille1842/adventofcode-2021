<?php

namespace PilleAoc2021\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ListPuzzlesCommand extends AbstractCommand
{
    protected static $defaultName = 'puzzles';
    protected static $defaultDescription = 'List all available puzzles';

    protected function configure(): void
    {
        $this
            ->setHelp('List all available puzzles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->puzzleClasses as $puzzle => $class) {
            $output->writeln($puzzle);
        }

        return Command::SUCCESS;
    }
}
