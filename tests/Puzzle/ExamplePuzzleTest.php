<?php declare(strict_types=1);

namespace PilleAoc2021Tests;

use PHPUnit\Framework\TestCase;
use PilleAoc2021\Puzzle\ExamplePuzzle;

final class ExamplePuzzleTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(ExamplePuzzle::class, new ExamplePuzzle());
    }

    public function testSolvesExampleInput(): void
    {
        $puzzle = new ExamplePuzzle();
        $puzzle->setInput("  This is some example input for the example puzzle  ");

        $this->assertEquals(
            "This is some example input for the example puzzle",
            $puzzle->solve()
        );
    }
}
