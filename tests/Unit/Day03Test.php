<?php

namespace Aoc\Tests\Unit;

use Aoc\Day03;
use PHPUnit\Framework\TestCase;

final class Day03Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day03();
        $input = <<<TXT
467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..
TXT;

        $this->assertSame($dayPuzzle->solvePart1($input), 4361);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day03();
        $input = Helper::getSampleData('Day03Sample.data');

        $this->assertSame($dayPuzzle->solvePart2($input), 467835);
    }

    public function testPart1EdgeCaseInput(): void
    {
        $dayPuzzle = new Day03();
        $input = <<<TXT
467..114..
x.........
..35..633.
..........
617......x
........8.
..592x....
......755.
..........
.664.598x.
TXT;

        $this->assertSame($dayPuzzle->solvePart1($input), 2420);
    }

    /**
     * @dataProvider providerLinesAndRangeHaveSymbols
     */
    public function testLinesAndRangeHaveSymbols(
        string $lines,
        int $lineNumber,
        int $rangeStart,
        int $rangeEnd,
        bool $output
    ): void {
        $dayPuzzle = new Day03();
        $this->assertSame(
            $dayPuzzle->linesAndRangeHaveSymbols(
                explode("\n", $lines),
                $lineNumber,
                $rangeStart,
                $rangeEnd
            ),
            $output
        );
    }

    public static function providerLinesAndRangeHaveSymbols(): array
    {
        return [
            [".......\n..123..\n.......", 1, 1, 6, false],
            ["..x....\n.......\n.......", 1, 1, 6, true],
            [".......\n...x...\n.......", 1, 1, 6, true],
            [".......\n.......\n...x...", 1, 1, 6, true],
            [".......\n.123...\n.......", 1, 0, 5, false],
            ["......x\n.123...\n......x", 1, 0, 5, false],
            [".....x.\n123..x.\n.....x.", 1, 0, 4, false],
            ["...x...\n.123...\n.......", 1, 0, 5, true],
            [".......\nx123...\n.......", 1, 0, 5, true],
            [".......\n.123...\n..x....", 1, 0, 5, true],
            [".x.....\n..123..\n.......", 1, 1, 6, true],
            [".......\n..123..\n.x.....", 1, 1, 6, true],
        ];
    }

    /**
     * @dataProvider providerRangeHasSymbols
     */
    public function testRangeHasSymbols(string $line, int $rangeStart, int $rangeEnd, bool $output): void
    {
        $dayPuzzle = new Day03();
        $this->assertSame($dayPuzzle->rangeHasSymbols($line, $rangeStart, $rangeEnd), $output);
    }

    public static function providerRangeHasSymbols(): array
    {
        return [
            ['.......', 1, 6, false],
            ['..123..', 1, 6, false],
            ['..123#.', 1, 6, true],
            ['.#123..', 1, 6, true],
            ['.#123#.', 1, 6, true],
        ];
    }

    /**
     * @dataProvider providerPart2SmallExamples
     */
    public function testPart2SmallExamples(string $input, int $output): void
    {
        $dayPuzzle = new Day03();
        $this->assertSame($dayPuzzle->solvePart2($input), $output);
    }

    public static function providerPart2SmallExamples(): array
    {
        return [
            [".......\n..1*3..\n.......", 3],
            ["..1....\n...*3..\n.......", 3],
            [".......\n...*3..\n..1....", 3],
        ];
    }

    /**
     * @dataProvider providerSearchNumberOnLineFromPosition
     */
    public function testSearchNumberOnLineFromPosition(string $line, int $index, array $output): void
    {
        $dayPuzzle = new Day03();
        $this->assertSame($dayPuzzle->searchNumberOnLineFromPosition($line, $index), $output);
    }

    public static function providerSearchNumberOnLineFromPosition(): array
    {
        return [
            ['..1234..', 2, [1234]],
            ['..1.34..', 3, [1, 34]],
            ['.11.34..', 3, [11, 34]],
        ];
    }

    /**
     * @dataProvider providerLookLeftAndRightForNumber
     */
    public function testLookLeftAndRightForNumber(string $line, int $index, int $output): void
    {
        $dayPuzzle = new Day03();
        $this->assertSame($dayPuzzle->lookLeftAndRightForNumber($line, $index), $output);
    }

    public static function providerLookLeftAndRightForNumber(): array
    {
        return [
            ['..1234..', 2, 1234],
            ['..1.34..', 2, 1],
            ['..1.34..', 4, 34],
            ['..1234..', 3, 1234],
            ['..1234..', 4, 1234],
            ['..1234..', 5, 1234],
            ['..1234', 5, 1234],
            ['1234', 2, 1234],
        ];
    }
}
