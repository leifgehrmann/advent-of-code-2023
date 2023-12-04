<?php

namespace Aoc\Tests\Unit;

use Aoc\Day04;
use PHPUnit\Framework\TestCase;

final class Day04Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day04();
        $exampleInput = Helper::getSampleData('Day04Sample.data');
        $cardStrings = explode("\n", $exampleInput);
        $cards = array_map(fn ($cardString) => $dayPuzzle->parseCardString($cardString), $cardStrings);
        $this->assertSame(13, $dayPuzzle->solvePart1($cards));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day04();
        $exampleInput = Helper::getSampleData('Day04Sample.data');
        $cardStrings = explode("\n", $exampleInput);
        $cards = array_map(fn ($cardString) => $dayPuzzle->parseCardString($cardString), $cardStrings);
        $this->assertSame(30, $dayPuzzle->solvePart2($cards));
    }

    /**
     * @dataProvider providerScoreCard
     */
    public function testScoreCard(string $cardString, int $expectedScore): void
    {
        $dayPuzzle = new Day04();
        $card = $dayPuzzle->parseCardString($cardString);
        $this->assertSame($expectedScore, $dayPuzzle->scoreCard($card));
    }

    public static function providerScoreCard(): array
    {
        $exampleInput = explode("\n", Helper::getSampleData('Day04Sample.data'));
        return [
            [$exampleInput[0], 8],
            [$exampleInput[1], 2],
            [$exampleInput[2], 2],
            [$exampleInput[3], 1],
            [$exampleInput[4], 0],
            [$exampleInput[5], 0],
        ];
    }

    /**
     * @dataProvider providerParseCardString
     */
    public function testParseCardString(string $cardString, $expectedArray): void
    {
        $dayPuzzle = new Day04();
        $this->assertSame($expectedArray, $dayPuzzle->parseCardString($cardString));
    }

    public static function providerParseCardString(): array
    {
        return [
            [
                'Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1',
                [
                    'id' => 3,
                    'winningNumbers' => [1, 21, 53, 59, 44],
                    'selectedNumbers' => [69, 82, 63, 72, 16, 21, 14, 1],
                ]
            ],
            [
                'Card 202: ' .
                '92 67 16 37 19  9  2 74 41 34 | ' .
                '96 13 70 82 48 27 58 17 14 61 18 81 43 15 32 69 80 76 31 47 84 90 40 75 60',
                [
                    'id' => 202,
                    'winningNumbers' => [92, 67, 16, 37, 19, 9, 2, 74, 41, 34],
                    'selectedNumbers' => [
                        96, 13, 70, 82, 48, 27, 58, 17, 14, 61, 18, 81, 43,
                        15, 32, 69, 80, 76, 31, 47, 84, 90, 40, 75, 60],
                ]
            ],
        ];
    }
}
