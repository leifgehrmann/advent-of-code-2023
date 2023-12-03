<?php

namespace Aoc\Tests\Unit;

use Aoc\Day04;
use PHPUnit\Framework\TestCase;

final class Day04Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day04();

        $this->assertSame($dayPuzzle->solvePart1(), 0);
    }
}
