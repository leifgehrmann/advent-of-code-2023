<?php

namespace Aoc\Tests\Unit;

use Aoc\Day12;
use PHPUnit\Framework\TestCase;

final class Day12Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day12();
        $input = Helper::getSampleData('Day12Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(21, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day12();
        $input = Helper::getSampleData('Day12Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(525152, $dayPuzzle->solvePart2($puzzle));
    }

    /**
     * @dataProvider providerCountArrangements
     */
    public function testCountArrangements($line, $groups, $count): void
    {
        $dayPuzzle = new Day12();
        $this->assertSame($count, $dayPuzzle->countArrangements($line, $dayPuzzle->buildPattern($groups)));
    }

    public static function providerCountArrangements(): array
    {
        return [
            ['???.###', [1, 1, 3], 1],
            ['.??..??...?##.', [1, 1, 3], 4],
            ['?#?#?#?#?#?#?#?', [1, 3, 1, 6], 1],
            ['????.#...#...', [4, 1, 1], 1],
            ['????.######..#####.', [1, 6, 5], 4],
            ['?###????????', [3,2,1], 10],
        ];
    }

    /**
     * @dataProvider providerMatchesLine
     */
    public function testMatchesLine($line, $groups, $matches): void
    {
        $dayPuzzle = new Day12();
        $this->assertSame($matches, $dayPuzzle->matchesLine($line, $dayPuzzle->buildPattern($groups)));
    }

    public static function providerMatchesLine(): array
    {
        return [
            ['???.###', [1, 1, 3], true],
            ['.??..??...?##.', [1, 1, 3], true],
            ['?#?#?#?#?#?#?#?', [1, 3, 1, 6], true],
            ['????.#...#...', [4, 1, 1], true],
            ['????.######..#####.', [1, 6, 5], true],
            ['?###????????', [3,2,1], true],
        ];
    }
}
