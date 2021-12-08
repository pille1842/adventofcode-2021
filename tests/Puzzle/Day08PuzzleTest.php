<?php declare(strict_types=1);

namespace PilleAoc2021Tests;

use PHPUnit\Framework\TestCase;
use PilleAoc2021\Puzzle\Day08Puzzle;

final class Day08PuzzleTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Day08Puzzle::class, new Day08Puzzle());
    }

    public function testSolvesExampleInput(): void
    {
        $puzzle = new Day08Puzzle();
        $puzzle->setInput(
            "be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe\n" .
            "edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc\n" .
            "fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg\n" .
            "fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb\n" .
            "aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea\n" .
            "fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb\n" .
            "dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe\n" .
            "bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef\n" .
            "egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb\n" .
            "gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce\n"
        );

        $this->assertEquals(
            "Digits 1, 4, 7, or 8 appear 26 times in the output values.\n" .
            "The sum of all output values is 61229.",
            $puzzle->solve()
        );
    }
}
