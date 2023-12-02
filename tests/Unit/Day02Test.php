<?php

namespace Aoc\Tests\Unit;

use Aoc\Day02;
use PHPUnit\Framework\TestCase;

final class Day02Test extends TestCase
{
    public function testParser(): void
    {
        $dayPuzzle = new Day02();
        $gameString = 'Game 73: 4 red, 3 blue, 1 green;' .
            ' 10 red, 2 blue, 3 green;' .
            ' 14 red;' .
            ' 1 blue;' .
            ' 3 green, 9 red, 6 blue;' .
            ' 11 red, 7 blue, 2 green';
        $parsedGame = $dayPuzzle->parseGame($gameString);
        $this->assertSame($parsedGame['id'], 73);
        $this->assertSame($parsedGame['cubeSubsets'][0], ['red' => 4, 'green' => 1, 'blue' => 3]);
        $this->assertSame($parsedGame['cubeSubsets'][1], ['red' => 10, 'green' => 3, 'blue' => 2]);
        $this->assertSame($parsedGame['cubeSubsets'][2], ['red' => 14, 'green' => 0, 'blue' => 0]);
        $this->assertSame($parsedGame['cubeSubsets'][3], ['red' => 0, 'green' => 0, 'blue' => 1]);
        $this->assertSame($parsedGame['cubeSubsets'][4], ['red' => 9, 'green' => 3, 'blue' => 6]);
        $this->assertSame($parsedGame['cubeSubsets'][5], ['red' => 11, 'green' => 2, 'blue' => 7]);
    }

    public function testPart1SumsPossibleGames(): void
    {
        $dayPuzzle = new Day02();
        $gameString = 'Game 73: 4 red, 3 blue, 1 green;' .
            ' 10 red, 2 blue, 3 green;' .
            ' 11 red;' .
            ' 1 blue;' .
            ' 3 green, 9 red, 6 blue;' .
            ' 11 red, 7 blue, 2 green';
        $parsedGame = $dayPuzzle->parseGame($gameString);
        $this->assertSame($dayPuzzle->solvePart1([$parsedGame]), 73);
    }

    public function testPart1DoesNotSumImpossibleGames(): void
    {
        $dayPuzzle = new Day02();
        $gameString = 'Game 73: 20 red, 3 blue, 1 green';
        $parsedGame = $dayPuzzle->parseGame($gameString);
        $this->assertSame($dayPuzzle->solvePart1([$parsedGame]), 0);
    }

    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day02();
        $gameStrings = [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
            'Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red',
            'Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red',
            'Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green',
        ];
        $games = array_map(fn($gameString) => $dayPuzzle->parseGame($gameString), $gameStrings);
        $this->assertSame($dayPuzzle->solvePart1($games), 8);
    }
}
