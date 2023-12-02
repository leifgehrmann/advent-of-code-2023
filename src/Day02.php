<?php

namespace Aoc;

use Exception;

/**
 * @psalm-type CubeSubset = array{
 *        red: int,
 *        green: int,
 *        blue: int
 *   }
 * @psalm-type Game = array{
 *        id: int,
 *        cubeSubsets: list<CubeSubset>,
 *   }
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day02 extends AbstractDay
{
    /**
     * @param Game[] $games
     * @return int
     */
    public function solvePart1(array $games): int
    {
        $validGames = array_filter($games, function ($game) {
            $maxRedCube = 12;
            $maxGreenCube = 13;
            $maxBlueCube = 14;
            foreach ($game['cubeSubsets'] as $cubeSubset) {
                if (
                    $cubeSubset['red'] > $maxRedCube ||
                    $cubeSubset['green'] > $maxGreenCube ||
                    $cubeSubset['blue'] > $maxBlueCube
                ) {
                    return false;
                }
            }
            return true;
        });

        return array_sum(array_map(fn ($validGame) => $validGame['id'], $validGames));
    }

    public function solvePart2(array $games): int
    {
        return array_sum(array_map(function ($game) {
            $maxRedCube = (int) max(0, ...array_column($game['cubeSubsets'], 'red'));
            $maxGreenCube = (int) max(0, ...array_column($game['cubeSubsets'], 'green'));
            $maxBlueCube = (int) max(0, ...array_column($game['cubeSubsets'], 'blue'));
            return $maxRedCube * $maxGreenCube * $maxBlueCube;
        }, $games));
    }

    /**
     * @param string $gameString
     * @return Game
     */
    public function parseGame(string $gameString): array
    {
        $gameRe = '/Game (?P<id>[0-9]+): (?P<cubeSubsets>.*)/';
        preg_match($gameRe, $gameString, $matches);
        $id = intval($matches['id']);
        $cubeSubsetsStrings = explode('; ', $matches['cubeSubsets']);

        $cubeSubsets = [];
        $cubeSubsetRe = '/(?P<count>[0-9]+) (?P<color>[^,]+)/';
        foreach ($cubeSubsetsStrings as $cubeSubsetString) {
            $cubeSubset = [
                'red' => 0,
                'green' => 0,
                'blue' => 0,
            ];
            preg_match_all($cubeSubsetRe, $cubeSubsetString, $matches, PREG_SET_ORDER, 0);
            foreach ($matches as $match) {
                /** @var "red"|"green"|"blue" $color */
                $color = $match['color'];
                $cubeSubset[$color] = intval($match['count']);
            }
            $cubeSubsets[] = $cubeSubset;
        }

        return [
            'id' => $id,
            'cubeSubsets' => $cubeSubsets,
        ];
    }

    public function solve(): array
    {
        $gameStrings = explode("\n", $this->getInputString());
        $games = array_map(fn($gameString) => $this->parseGame($gameString), $gameStrings);

        return [
            "Part 1" => $this->solvePart1($games),
            "Part 2" => $this->solvePart2($games),
        ];
    }
}
