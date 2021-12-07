<?php declare(strict_types=1);

namespace PilleAoc2021Tests;

use PHPUnit\Framework\TestCase;
use PilleAoc2021\Puzzle\Day07Puzzle;

final class Day07PuzzleTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Day07Puzzle::class, new Day07Puzzle());
    }

    public function testSolvesExampleInput(): void
    {
        $puzzle = new Day07Puzzle();
        $puzzle->setInput("16,1,2,0,4,2,7,1,2,14\n");

        $this->assertEquals(
            "Part 1: Most fuel-efficient position: 2 (fuel expended: 37)\n" .
            "Part 2: Most fuel-efficient position: 5 (fuel expended: 168)",
            $puzzle->solve()
        );
    }
}
