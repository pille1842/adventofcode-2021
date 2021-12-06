<?php declare(strict_types=1);

namespace PilleAoc2021Tests;

use PHPUnit\Framework\TestCase;
use PilleAoc2021\Puzzle\Day06Puzzle;

final class Day06PuzzleTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Day06Puzzle::class, new Day06Puzzle());
    }

    public function testSolvesExampleInput(): void
    {
        $puzzle = new Day06Puzzle();
        $puzzle->setInput("3,4,3,1,2\n");

        $this->assertEquals(
            "# of fish after  80 days: 5934\n# of fish after 256 days: 26984457539",
            $puzzle->solve()
        );
    }
}
