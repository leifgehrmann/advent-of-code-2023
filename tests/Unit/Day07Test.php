<?php

namespace Aoc\Tests\Unit;

use Aoc\Day07;
use PHPUnit\Framework\TestCase;

final class Day07Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day07();
        $input = Helper::getSampleData('Day07Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(6440, $dayPuzzle->solvePart1($puzzle));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day07();
        $input = Helper::getSampleData('Day07Sample.data');
        $puzzle = $dayPuzzle->parsePuzzle($input);
        $this->assertSame(5905, $dayPuzzle->solvePart2($puzzle));
    }

    /**
     * @dataProvider providerCompareHandStrength
     */
    public function testCompareHandStrength(string $handA, string $handB, $expected): void
    {
        $dayPuzzle = new Day07();
        $this->assertSame($expected, $dayPuzzle->compareHandStrength($handA, $handB));
    }

    public static function providerCompareHandStrength(): array
    {
        return [
            ['KK677', 'KTJJT', 1],
            ['KTJJT', 'KK677', -1],
        ];
    }

    /**
     * @dataProvider providerGetHandType
     */
    public function testGetHandType(string $hand, $expected): void
    {
        $dayPuzzle = new Day07();
        $this->assertSame($expected, $dayPuzzle->getHandType($hand));
    }

    public static function providerGetHandType(): array
    {
        return [
            ['AAAAA', Day07::FIVE_OF_A_KIND],
            ['AA8AA', Day07::FOUR_OF_A_KIND],
            ['23332', Day07::FULL_HOUSE],
            ['TTT98', Day07::THREE_OF_A_KIND],
            ['23432', Day07::TWO_PAIR],
            ['A23A4', Day07::ONE_PAIR],
            ['12345', Day07::HIGH_CARD],
        ];
    }

    /**
     * @dataProvider providerCompareHandWithJokerRule
     */
    public function testCompareHandWithJokerRule(string $handA, string $handB, $expected): void
    {
        $dayPuzzle = new Day07();
        $this->assertSame($expected, $dayPuzzle->compareHandWithJokerRule($handA, $handB));
    }

    public static function providerCompareHandWithJokerRule(): array
    {
        return [
            ['KTJJT', 'QQQJA', 1],
            ['QQQJA', 'T55J5', 1],
            ['T55J5', 'KK677', 1],
            ['KK677', 'T3K', 1],
        ];
    }

    /**
     * @dataProvider providerGetHandTypeWithJokerRule
     */
    public function testGetHandTypeWithJokerRule(string $hand, $expected): void
    {
        $dayPuzzle = new Day07();
        $this->assertSame($expected, $dayPuzzle->getHandTypeWithJokerRule($hand));
    }

    public static function providerGetHandTypeWithJokerRule(): array
    {
        return [
            ['32T3K', Day07::ONE_PAIR],
            ['KK677', Day07::TWO_PAIR],
            ['T55J5', Day07::FOUR_OF_A_KIND],
            ['KTJJT', Day07::FOUR_OF_A_KIND],
            ['QQQJA', Day07::FOUR_OF_A_KIND],
            ['JJJJJ', Day07::FIVE_OF_A_KIND],
            ['JJJJA', Day07::FIVE_OF_A_KIND],
            ['JJJAA', Day07::FIVE_OF_A_KIND],
            ['JJJAB', Day07::FOUR_OF_A_KIND],
            ['JJAAA', Day07::FIVE_OF_A_KIND],
            ['JJAAB', Day07::FOUR_OF_A_KIND],
            ['JJABC', Day07::THREE_OF_A_KIND],
            ['JAAAA', Day07::FIVE_OF_A_KIND],
            ['JAAAB', Day07::FOUR_OF_A_KIND],
            ['JAABC', Day07::THREE_OF_A_KIND],
            ['JABCD', Day07::ONE_PAIR],
        ];
    }
}
