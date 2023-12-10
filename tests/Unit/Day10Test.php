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

    public function testPart2ExampleInput3(): void
    {
        $dayPuzzle = new Day10();
        $input = Helper::getSampleData('Day10Sample3.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(4, $dayPuzzle->solvePart2($map));
    }

    public function testPart2ExampleInput4(): void
    {
        $dayPuzzle = new Day10();
        $input = Helper::getSampleData('Day10Sample4.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(4, $dayPuzzle->solvePart2($map));
    }

    public function testPart2ExampleInput5(): void
    {
        $dayPuzzle = new Day10();
        $input = Helper::getSampleData('Day10Sample5.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(8, $dayPuzzle->solvePart2($map));
    }

    public function testPart2ExampleInput6(): void
    {
        $dayPuzzle = new Day10();
        $input = Helper::getSampleData('Day10Sample6.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(10, $dayPuzzle->solvePart2($map));
    }
}
