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
}
