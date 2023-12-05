<?php

namespace Aoc;

/**
 * @psalm-type     Range = array{
 *         destination: int,
 *         source: int,
 *         length: int,
 *    }
 * @psalm-type     Map = list<Range>
 * @psalm-type     Puzzle = array{
 *         seeds: list<int>,
 *         maps: list<Map>,
 *    }
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day05 extends AbstractDay
{
    /**
     * @param Puzzle $puzzle
     * @return int
     */
    public function solvePart1(array $puzzle): int
    {
        $seedValues = [];
        foreach ($puzzle['seeds'] as $seed) {
            $source = $seed;
            foreach ($puzzle['maps'] as $map) {
                $source = $this->findMappedValue($source, $map);
            }
            $seedValues[] = $source;
        }
        return min(PHP_INT_MAX, ...$seedValues);
    }

    /**
     * @param int $source
     * @param Map $map
     * @return int
     */
    public function findMappedValue(int $source, array $map): int
    {
        foreach ($map as $range) {
            if (
                ($source >= $range['source']) &&
                ($source < $range['source'] + $range['length'])
            ) {
                $delta = $source - $range['source'];
                return $range['destination'] + $delta;
            }
        }
        return $source;
    }

    /**
     * @param string $input
     * @return Puzzle
     */
    public function parsePuzzle(string $input): array
    {
        $splitInput = explode("\n\n", $input);

        // Parse Seeds
        $seedsAsStrings = explode(' ', $splitInput[0]);
        array_shift($seedsAsStrings);
        $seeds = array_map(fn($str) => intval($str), $seedsAsStrings);

        array_shift($splitInput);

        $maps = [];
        foreach ($splitInput as $mapAsString) {
            $maps[] = $this->parseMap($mapAsString);
        }

        return [
            'seeds' => $seeds,
            'maps' => $maps,
        ];
    }

    /**
     * @param string $input
     * @return Map
     */
    public function parseMap(string $input): array
    {
        $mapLines = explode("\n", $input);
        array_shift($mapLines);
        return array_map(
            function ($line) {
                $values = explode(' ', $line);
                return [
                    'destination' => intval($values[0]),
                    'source' => intval($values[1]),
                    'length' => intval($values[2]),
                ];
            },
            $mapLines
        );
    }

    public function solve(): array
    {
        $puzzle = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($puzzle),
        ];
    }
}
