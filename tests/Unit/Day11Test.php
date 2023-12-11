<?php

namespace Aoc\Tests\Unit;

use Aoc\Day11;
use PHPUnit\Framework\TestCase;

final class Day11Test extends TestCase
{
    public function testPart1ExampleInput1(): void
    {
        $dayPuzzle = new Day11();
        $input = Helper::getSampleData('Day11Sample.data');
        $map = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(374, $dayPuzzle->solvePart1($map));
    }
}
