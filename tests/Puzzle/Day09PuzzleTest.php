<?php declare(strict_types=1);

namespace PilleAoc2021Tests;

use PHPUnit\Framework\TestCase;
use PilleAoc2021\Puzzle\Day09Puzzle;

final class Day09PuzzleTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Day09Puzzle::class, new Day09Puzzle());
    }

    public function testSolvesExampleInput(): void
    {
        $puzzle = new Day09Puzzle();
        $puzzle->setInput(
            "2199943210\n" .
            "3987894921\n" .
            "9856789892\n" .
            "8767896789\n" .
            "9899965678\n"
        );

        $this->assertEquals(
            "Sum of risk levels of all low points: 15\n" .
            "Product of the three largest basins:  1134",
            $puzzle->solve()
        );
    }
}
