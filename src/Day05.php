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
 *         seeds: array{int},
 *         maps: array{Map},
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
        $locationValues = [];
        foreach ($puzzle['seeds'] as $seed) {
            $source = $seed;
            foreach ($puzzle['maps'] as $map) {
                $source = $this->findMappedValue($source, $map);
            }
            $locationValues[] = $source;
        }
        return min(PHP_INT_MAX, ...$locationValues);
    }

    /**
     * @param Puzzle $puzzle
     * @return int
     */
    public function solvePart2(array $puzzle): int
    {
        // Re-interpret Seeds array
        /** @var array{array{0: int, 1: int}} $seedRanges */
        $seedRanges = array_chunk($puzzle['seeds'], 2);

        $newSeeds = [];

        foreach ($seedRanges as $seedRange) {
            $newSeeds[] = $seedRange[0];
        }

        foreach (range(1, count($puzzle['maps'])) as $mapLevels) {
            $map = $puzzle['maps'][$mapLevels - 1];
            foreach ($map as $range) {
                $destination = $range['destination'];
                $seedIndex = $this->findReverseMappedValueUsingMaps(
                    $destination,
                    $puzzle['maps'],
                    $mapLevels
                );
                $newSeeds[] = $seedIndex;
            }
        }

        $newSeeds = array_filter(
            $newSeeds,
            fn ($seedIndex) => $this->seedIndexIsInSeedRanges($seedIndex, $seedRanges)
        );
        $puzzle['seeds'] = $newSeeds;
        return $this->solvePart1($puzzle);
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
     * @param int $destination
     * @param array{Map} $maps
     * @param int $mapLevels
     * @return int
     */
    public function findReverseMappedValueUsingMaps(int $destination, array $maps, int $mapLevels): int
    {
        $value = $destination;
        $mapsToUse = array_reverse(array_slice($maps, 0, $mapLevels));
        foreach ($mapsToUse as $mapToUse) {
            $value = $this->findReverseMappedValue($value, $mapToUse);
        }
        return $value;
    }

    /**
     * @param int $destination
     * @param Map $map
     * @return int
     */
    public function findReverseMappedValue(int $destination, array $map): int
    {
        foreach ($map as $range) {
            if (
                ($destination >= $range['destination']) &&
                ($destination < $range['destination'] + $range['length'])
            ) {
                $delta = $destination - $range['destination'];
                return $range['source'] + $delta;
            }
        }
        return $destination;
    }

    /**
     * @param int $seedIndex
     * @param array{array{0: int, 1: int}} $seedRanges
     * @return bool
     */
    public function seedIndexIsInSeedRanges(int $seedIndex, array $seedRanges): bool
    {
        foreach ($seedRanges as $seedRange) {
            if ($seedIndex >= $seedRange[0] && $seedIndex < $seedRange[0] + $seedRange[1]) {
                return true;
            }
        }
        return false;
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
            "Part 2" => $this->solvePart2($puzzle),
        ];
    }
}
