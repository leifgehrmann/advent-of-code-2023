<?php

namespace Aoc\Tests\Unit;

use Aoc\Day14;
use PHPUnit\Framework\TestCase;

final class Day14Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day14();
        $input = Helper::getSampleData('Day14Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(136, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day14();
        $input = Helper::getSampleData('Day14Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(64, $dayPuzzle->solvePart2($puzzle));
    }

    public function testPart2ExampleInputWith3Cycles(): void
    {
        $dayPuzzle = new Day14();
        $input = Helper::getSampleData('Day14Sample.data');
        $map = $dayPuzzle->parsePuzzle($input);

        $map1CycleExpected = $dayPuzzle->parsePuzzle(Helper::getSampleData('Day14SampleCycle1.data'));
        $map1Cycle = $dayPuzzle->cycle($map);
        $this->assertSame($map1CycleExpected, $map1Cycle);

        $map2CycleExpected = $dayPuzzle->parsePuzzle(Helper::getSampleData('Day14SampleCycle2.data'));
        $map2Cycle = $dayPuzzle->cycle($map1Cycle);
        $this->assertSame($map2CycleExpected, $map2Cycle);

        $map3CycleExpected = $dayPuzzle->parsePuzzle(Helper::getSampleData('Day14SampleCycle3.data'));
        $map3Cycle = $dayPuzzle->cycle($map2Cycle);
        $this->assertSame($map3CycleExpected, $map3Cycle);
    }
}
