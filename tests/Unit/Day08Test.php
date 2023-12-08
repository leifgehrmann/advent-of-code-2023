<?php

namespace Aoc\Tests\Unit;

use Aoc\Day08;
use PHPUnit\Framework\TestCase;

final class Day08Test extends TestCase
{
    public function testPart1ExampleInput1(): void
    {
        $dayPuzzle = new Day08();
        $input = Helper::getSampleData('Day08Sample1.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(2, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart1ExampleInput2(): void
    {
        $dayPuzzle = new Day08();
        $input = Helper::getSampleData('Day08Sample2.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(6, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart2ExampleInput2(): void
    {
        $dayPuzzle = new Day08();
        $input = Helper::getSampleData('Day08Sample3.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(6, $dayPuzzle->solvePart2($puzzle));
    }
}
