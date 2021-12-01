#!/usr/bin/env php
<?php

use PilleAoc2021\Command\SolvePuzzleCommand;
use Symfony\Component\Console\Application;

require_once 'vendor/autoload.php';

$application = new Application();

$application->setName("Advent of Code 2021");
$application->setVersion("0.1.0");

$application->add(new SolvePuzzleCommand());

$application->run();
