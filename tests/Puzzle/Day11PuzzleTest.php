<?php declare(strict_types=1);

namespace PilleAoc2021Tests;

use PHPUnit\Framework\TestCase;
use PilleAoc2021\Puzzle\Day11Puzzle;

final class Day11PuzzleTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Day11Puzzle::class, new Day11Puzzle());
    }

    public function testSolvesExampleInput(): void
    {
        $puzzle = new Day11Puzzle();
        $puzzle->setInput(
            "5483143223\n" .
            "2745854711\n" .
            "5264556173\n" .
            "6141336146\n" .
            "6357385478\n" .
            "4167524645\n" .
            "2176841721\n" .
            "6882881134\n" .
            "4846848554\n" .
            "5283751526"
        );

        $this->assertEquals(
            "Total flashes after 100 steps: 1656\n" .
            "First step during which all octopuses flash: 195",
            $puzzle->solve()
        );
    }
}
