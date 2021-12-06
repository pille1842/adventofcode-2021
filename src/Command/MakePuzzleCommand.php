<?php

namespace PilleAoc2021\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class MakePuzzleCommand extends AbstractCommand
{
    protected static $defaultName = 'make';
    protected static $defaultDescription = 'Make a scaffolding puzzle class for the given day and fetch its input';

    protected function configure(): void
    {
        $this
            ->setHelp('Make a scaffolding puzzle class for the given day and fetch its input')
            ->addArgument('day', InputArgument::REQUIRED, 'Day number (1-25)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $day = $input->getArgument('day');
            $className = sprintf('Day%02dPuzzle', $day);
            $fileName = $className . '.php';
            $testName = $className . 'Test.php';
            $puzzleName = sprintf('day%02d', $day);

            $command = $this->getApplication()->find('fetch');

            $arguments = [
                'day' => $day,
            ];

            $fetchInput = new ArrayInput($arguments);
            $returnCode = $command->run($fetchInput, $output);

            if ($returnCode !== Command::SUCCESS) {
                throw new \Exception("Error while fetching the input file, not making a puzzle class");
            }

            // Make puzzle class
            $templatePath = implode(DIRECTORY_SEPARATOR, [
                dirname(__FILE__),
                '..',
                '..',
                'puzzle_template.txt',
            ]);

            $outputPath = implode(DIRECTORY_SEPARATOR, [
                dirname(__FILE__),
                '..',
                'Puzzle',
                $fileName,
            ]);

            if (!file_exists($templatePath)) {
                throw new \Exception("Template file $templatePath does not exist.");
            }

            if (!is_readable($templatePath)) {
                throw new \Exception("Template file $templatePath is unreadable.");
            }

            if (file_exists($outputPath)) {
                throw new \Exception(
                    sprintf("Puzzle class %s already defined in %s", $className, realpath($outputPath))
                );
            }

            $template = file_get_contents($templatePath);
            $template = str_replace('%%CLASS_NAME%%', $className, $template);
            $template = str_replace('%%PUZZLE_NAME%%', $puzzleName, $template);

            file_put_contents($outputPath, $template);
            $output->writeln(sprintf("Your new puzzle class has been saved as %s", realpath($outputPath)));

            // Make test case
            $templatePath = implode(DIRECTORY_SEPARATOR, [
                dirname(__FILE__),
                '..',
                '..',
                'test_template.txt',
            ]);

            $outputPath = implode(DIRECTORY_SEPARATOR, [
                dirname(__FILE__),
                '..',
                '..',
                'tests',
                'Puzzle',
                $testName,
            ]);

            if (!file_exists($templatePath)) {
                throw new \Exception("Template file $templatePath does not exist.");
            }

            if (!is_readable($templatePath)) {
                throw new \Exception("Template file $templatePath is unreadable.");
            }

            if (file_exists($outputPath)) {
                throw new \Exception(
                    sprintf("Puzzle test case %s already defined in %s", $className, realpath($outputPath))
                );
            }

            $template = file_get_contents($templatePath);
            $template = str_replace('%%CLASS_NAME%%', $className, $template);
            $template = str_replace('%%PUZZLE_NAME%%', $puzzleName, $template);

            file_put_contents($outputPath, $template);
            $output->writeln(sprintf("Your new puzzle test case has been saved as %s", realpath($outputPath)));
        } catch (\Exception $e) {
            $formattedError = $this->formatError($e->getMessage());
            $output->writeln("\n" . $formattedError . "\n");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
