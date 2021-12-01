<?php

namespace PilleAoc2021\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FetchInputCommand extends AbstractCommand
{
    protected static $defaultName = 'fetch';
    protected static $defaultDescription = 'Fetch the input file for the given day';

    protected function configure(): void
    {
        $this
            ->setHelp('Fetch the input file for the given day')
            ->addArgument('day', InputArgument::REQUIRED, 'Day number (1-25)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            if (!isset($_ENV['SESSION_COOKIE']) || !is_string($_ENV['SESSION_COOKIE'])) {
                throw new \Exception("You need to set a session cookie in the environment variable SESSION_COOKIE.");
            }

            $session = "session=" . $_ENV['SESSION_COOKIE'];
            $year = (int) date('Y');
            $day = (int) $input->getArgument('day');
            $currentDay = (int) date('d');
            $currentHour = (int) gmdate('H');
            $absolutePath = implode(DIRECTORY_SEPARATOR, [
                dirname(__FILE__),
                '..',
                '..',
                'input',
                sprintf('day%02d.txt', $day),
            ]);
            $url = sprintf("https://adventofcode.com/%d/day/%d/input", $year, $day);

            if ($day > $currentDay) {
                throw new \Exception("You cannot fetch input files for future days.");
            }

            if ($day == $currentDay && $currentHour < 5) {
                throw new \Exception("You cannot fetch today's input before 5:00 UTC.");
            }

            if (file_exists($absolutePath)) {
                $output->writeln(
                    sprintf(
                        "Input for this day has already been downloaded in %s, not downloading again",
                        realpath($absolutePath)
                    )
                );
                return Command::SUCCESS;
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_COOKIE, $session);
            $data = curl_exec($curl);
            curl_close($curl);

            if ($data === false) {
                throw new \Exception("Error while downloading $url");
            }

            file_put_contents($absolutePath, $data);
            $output->writeln(sprintf("Input for day %d has been saved in %s", $day, realpath($absolutePath)));
        } catch (\Exception $e) {
            $formattedError = $this->formatError($e->getMessage());
            $output->writeln("\n" . $formattedError . "\n");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
