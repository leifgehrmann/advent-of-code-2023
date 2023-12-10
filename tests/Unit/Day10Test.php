<?php

namespace Aoc\Tests\Unit;

use Aoc\Day10;
use PHPUnit\Framework\TestCase;

final class Day10Test extends TestCase
{
    public function testPart1ExampleInput1(): void
    {
        $dayPuzzle = new Day10();
        $input = Helper::getSampleData('Day10Sample1.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(4, $dayPuzzle->solvePart1($map));
    }

    public function testPart1ExampleInput2(): void
    {
        $dayPuzzle = new Day10();
        $input = Helper::getSampleData('Day10Sample2.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(8, $dayPuzzle->solvePart1($map));
    }
}
