#!/usr/bin/env php
<?php

use PilleAoc2021\Command\FetchInputCommand;
use PilleAoc2021\Command\SolvePuzzleCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

require_once 'vendor/autoload.php';

if (!isset($_ENV['APP_ENV'])) {
    $_ENV['APP_ENV'] = 'dev';
}

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

$application = new Application();

$application->setName("Advent of Code 2021");
$application->setVersion("0.1.0");

$application->add(new SolvePuzzleCommand());
$application->add(new FetchInputCommand());

$application->run();
