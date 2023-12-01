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
    public function solvePart1(array $lines): int
    {
        $sum = 0;
        $re = '/^[a-z]*([0-9])?[a-z0-9]*([0-9])[a-z]*$/m';
        foreach ($lines as $line) {
            preg_match($re, $line, $matches);
            $firstDigit = null;
            if ($matches[1] !== '') {
                $firstDigit = intval($matches[1]);
            }
            $secondDigit = intval($matches[2]);
            if ($firstDigit === null) {
                $firstDigit = $secondDigit;
            }
            $calibrationValue = $firstDigit * 10 + $secondDigit;
            $sum += $calibrationValue;
        }
        return $sum;
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
        $lines = explode("\n", $this->getInputString());

        return [
            "Part 1" => $this->solvePart1($lines),
            // "Part 2" => $this->solvePart2($entries)
        ];
    }
}
