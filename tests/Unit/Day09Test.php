<?php

namespace Aoc\Tests\Unit;

use Aoc\Day09;
use PHPUnit\Framework\TestCase;

final class Day09Test extends TestCase
{
    public function testPart1AndPart2ExampleInput(): void
    {
        $dayPuzzle = new Day09();
        $input = Helper::getSampleData('Day09Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(['nextSum' => 114, 'previousSum' => 2], $dayPuzzle->solvePart1AndPart2($puzzle));
    }

    public function testParsePuzzle(): void
    {
        $dayPuzzle = new Day09();
        $input = Helper::getSampleData('Day09Sample.data');
        $this->assertSame([
            [0, 3, 6, 9, 12, 15],
            [1, 3, 6, 10, 15, 21],
            [10, 13, 16, 21, 30, 45],
        ], $dayPuzzle->parsePuzzle($input));
    }

    /**
     * @dataProvider providerCalculateNextHistoryValue
     */
    public function testCalculateNextHistoryValue($history, $value): void
    {
        $dayPuzzle = new Day09();
        $this->assertSame($value, $dayPuzzle->calculateNextAndPreviousHistoryValues($history));
    }

    public static function providerCalculateNextHistoryValue(): array
    {
        return [
            [[0, 3, 6, 9, 12, 15], ['next' => 18, 'previous' => -3]],
            [[1, 3, 6, 10, 15, 21], ['next' => 28, 'previous' => 0]],
            [[10, 13, 16, 21, 30, 45], ['next' => 68, 'previous' => 5]]
        ];
    }
}
