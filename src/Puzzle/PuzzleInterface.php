<?php

namespace PilleAoc2021\Puzzle;

interface PuzzleInterface
{
    public function solve(): string;
    public function getInputFilename(): string;
    public function setInput(string $input): self;
}
