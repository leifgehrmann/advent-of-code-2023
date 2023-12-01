<?php

namespace Aoc\Tests\Unit;

use Aoc\Day01;
use PHPUnit\Framework\TestCase;

final class Day01Test extends TestCase
{
    public function testSolvePart1(): void
    {
        $dayPuzzle = new Day01();
        $this->assertSame($dayPuzzle->solvePart1(['123']), 13);
        $this->assertSame($dayPuzzle->solvePart1(['a123b']), 13);
        $this->assertSame($dayPuzzle->solvePart1(['a13b']), 13);
        $this->assertSame($dayPuzzle->solvePart1(['a1b3b']), 13);
        $this->assertSame($dayPuzzle->solvePart1(['aa1bb3bb']), 13);
        $this->assertSame($dayPuzzle->solvePart1(['a1b']), 11);
        $this->assertSame($dayPuzzle->solvePart1(['123456789']), 19);
        $this->assertSame($dayPuzzle->solvePart1(['9']), 99);
        $this->assertSame($dayPuzzle->solvePart1(['c']), 0);
    }

    public function testSolvePart2(): void
    {
        $dayPuzzle = new Day01();
        $this->assertSame($dayPuzzle->solvePart2(['xtwone3four']), 24);
        $this->assertSame($dayPuzzle->solvePart2(['eighthree']), 83);
        $this->assertSame($dayPuzzle->solvePart2(['sevenine']), 79);
    }
}
