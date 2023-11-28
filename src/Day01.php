<?php

namespace Aoc;

use Exception;

/**
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day01 extends AbstractDay
{
    /**
     * @param int[] $entries
     * @return int
     * @throws Exception
     */
    public function solvePart1(array $entries): int
    {
        foreach ($entries as $entryA) {
            foreach ($entries as $entryB) {
                if ($entryA + $entryB === 2020) {
                    return $entryA * $entryB;
                }
            }
        }
        throw new Exception('Failed to find mistake');
    }

    /**
     * @param int[] $entries
     * @return int
     * @throws Exception
     */
    public function solvePart2(array $entries): int
    {
        $maxRange = count($entries) - 1;
        foreach (range(0, $maxRange) as $a) {
            foreach (range($a, $maxRange) as $b) {
                if ($entries[$a] + $entries[$b] > 2020) {
                    continue;
                }
                foreach (range($b, $maxRange) as $c) {
                    if ($entries[$a] + $entries[$b] + $entries[$c] === 2020) {
                        return $entries[$a] * $entries[$b] * $entries[$c];
                    }
                }
            }
        }
        throw new Exception('Failed to find mistake');
    }

    public function solve(): array
    {
        $entries = array_map(
            fn ($val) => intval($val),
            explode("\n", $this->getInputString())
        );

        return [
            "Part 1" => $this->solvePart1($entries),
            "Part 2" => $this->solvePart2($entries)
        ];
    }
}
