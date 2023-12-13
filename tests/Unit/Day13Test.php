<?php

namespace Aoc\Tests\Unit;

use Aoc\Day13;
use PHPUnit\Framework\TestCase;

final class Day13Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day13();
        $input = Helper::getSampleData('Day13Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(405, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day13();
        $input = Helper::getSampleData('Day13Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(400, $dayPuzzle->solvePart2($puzzle));
    }
}
