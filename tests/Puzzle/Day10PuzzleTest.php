<?php declare(strict_types=1);

namespace PilleAoc2021Tests;

use PHPUnit\Framework\TestCase;
use PilleAoc2021\Puzzle\Day10Puzzle;

final class Day10PuzzleTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Day10Puzzle::class, new Day10Puzzle());
    }

    public function testSolvesExampleInput(): void
    {
        $puzzle = new Day10Puzzle();
        $puzzle->setInput(
            "[({(<(())[]>[[{[]{<()<>>\n" .
            "[(()[<>])]({[<{<<[]>>(\n" .
            "{([(<{}[<>[]}>{[]{[(<()>\n" .
            "(((({<>}<{<{<>}{[]{[]{}\n" .
            "[[<[([]))<([[{}[[()]]]\n" .
            "[{[{({}]{}}([{[{{{}}([]\n" .
            "{<[[]]>}<{[{[{[]{()[[[]\n" .
            "[<(<(<(<{}))><([]([]()\n" .
            "<{([([[(<>()){}]>(<<{{\n" .
            "<{([{{}}[<[[[<>{}]]]>[]]\n"
        );

        $this->assertEquals(
            "Total syntax error score: 26397\n" .
            "Middle score: 288957",
            $puzzle->solve()
        );
    }
}
