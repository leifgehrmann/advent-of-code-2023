<?php

namespace Aoc\Tests\Unit;

use Aoc\Day11;
use PHPUnit\Framework\TestCase;

final class Day11Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day11();
        $input = Helper::getSampleData('Day11Sample.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(374, $dayPuzzle->solvePart1($map));
    }

    public function testPart2ExampleInputWith10Expansion(): void
    {
        $dayPuzzle = new Day11();
        $input = Helper::getSampleData('Day11Sample.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(1030, $dayPuzzle->solvePart2($map, 10));
    }

    public function testPart2ExampleInputWith100Expansion(): void
    {
        $dayPuzzle = new Day11();
        $input = Helper::getSampleData('Day11Sample.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(8410, $dayPuzzle->solvePart2($map, 100));
    }
}
