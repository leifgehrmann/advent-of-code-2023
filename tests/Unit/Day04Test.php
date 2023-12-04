<?php

namespace Aoc\Tests\Unit;

use Aoc\Day04;
use PHPUnit\Framework\TestCase;

final class Day04Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day04();

        $exampleInput = <<<TXT
Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11
TXT;
        $cardStrings = explode("\n", $exampleInput);
        $cards = array_map(fn ($cardString) => $dayPuzzle->parseCardString($cardString), $cardStrings);
        $this->assertSame(13, $dayPuzzle->solvePart1($cards));
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day04();

        $exampleInput = <<<TXT
Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11
TXT;
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
        return [
            ['Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53', 8],
            ['Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19', 2],
            ['Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1', 2],
            ['Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83', 1],
            ['Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36', 0],
            ['Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11', 0],
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
