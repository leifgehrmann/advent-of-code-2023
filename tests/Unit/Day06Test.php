<?php

namespace Aoc\Tests\Unit;

use Aoc\Day06;
use PHPUnit\Framework\TestCase;

final class Day06Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day06();
        $input = Helper::getSampleData('Day06Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(288, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day06();
        $input = Helper::getSampleData('Day06Sample.data');
        $puzzle = $dayPuzzle->parsePuzzleForPart2($input);
        $this->assertSame(71503, $dayPuzzle->solvePart2($puzzle));
    }

    public function testParsePuzzle(): void
    {
        $dayPuzzle = new Day06();
        $input = Helper::getSampleData('Day06Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame([
            ['time' => 7, 'distance' => 9],
            ['time' => 15, 'distance' => 40],
            ['time' => 30, 'distance' => 200],
        ], $puzzle);
    }

    /**
     * @dataProvider providerCountRecordsThatBeat
     */
    public function testCountRecordsThatBeat(int $time, int $distanceToBeat, $expectedValue): void
    {
        $dayPuzzle = new Day06();
        $this->assertSame($expectedValue, $dayPuzzle->countRecordsThatBeat($time, $distanceToBeat));
    }

    public static function providerCountRecordsThatBeat(): array
    {
        return [
            [7, 9, 4],
            [15, 40, 8],
            [30, 200, 9],
        ];
    }
}
