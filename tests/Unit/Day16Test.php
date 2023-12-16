<?php

namespace Aoc\Tests\Unit;

use Aoc\Day16;
use PHPUnit\Framework\TestCase;

final class Day16Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day16();
        $input = Helper::getSampleData('Day16Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(46, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day16();
        $input = Helper::getSampleData('Day16Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(51, $dayPuzzle->solvePart2($puzzle));
    }
}
