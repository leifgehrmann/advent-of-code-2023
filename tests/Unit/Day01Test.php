<?php

namespace Aoc\Tests\Unit;

use Aoc\Day01;
use PHPUnit\Framework\TestCase;

final class Day01Test extends TestCase
{
    public function testTrivialCaseOfDay01(): void
    {
        $dayPuzzle = new Day01();
        $this->assertSame($dayPuzzle->solvePart1([1000, 1020]), 1000 * 1020);
    }
}
