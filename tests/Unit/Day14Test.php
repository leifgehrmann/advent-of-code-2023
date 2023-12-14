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
}
