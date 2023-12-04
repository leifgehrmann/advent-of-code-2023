<?php

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day01 extends AbstractDay
{
    /**
     * @param string[] $lines
     * @return int
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
     * @param string[] $lines
     * @return int
     */
    public function solvePart2(array $lines): int
    {
        $spelledNumbers = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $reversedSpelledNumbers = array_map(fn($num) => strrev($num), $spelledNumbers);
        $forwardRe = '/([0-9]|' . implode('|', $spelledNumbers) . ')/m';
        $backwardRe = '/([0-9]|' . implode('|', $reversedSpelledNumbers) . ')/m';

        $sum = 0;

        foreach ($lines as $line) {
            preg_match($forwardRe, $line, $matches);
            $firstDigit = $matches[1];

            preg_match($backwardRe, strrev($line), $matches);
            $secondDigit = $matches[1];

            if (strlen($firstDigit) > 1) {
                $firstDigit = (array_search($firstDigit, $spelledNumbers) ?: 0) + 1;
            } else {
                $firstDigit = intval($firstDigit);
            }

            if (strlen($secondDigit) > 1) {
                $secondDigit = (array_search($secondDigit, $reversedSpelledNumbers) ?: 0) + 1;
            } else {
                $secondDigit = intval($secondDigit);
            }

            $calibrationValue = $firstDigit * 10 + $secondDigit;
            $sum += $calibrationValue;
        }

        return $sum;
    }

    public function solve(): array
    {
        $lines = explode("\n", $this->getInputString());

        return [
            "Part 1" => $this->solvePart1($lines),
            "Part 2" => $this->solvePart2($lines)
        ];
    }
}
