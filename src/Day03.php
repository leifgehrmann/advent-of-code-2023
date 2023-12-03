<?php

namespace Aoc;

use Exception;

/**
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day03 extends AbstractDay
{
    /**
     * @param string $input
     * @return int
     */
    public function solvePart1(string $input): int
    {
        $lines = explode("\n", $input);

        $re = '/[0-9]+/m';

        $sum = 0;
        foreach ($lines as $lineIndex => $line) {
            $matches = [];
            preg_match_all($re, $line, $matches, PREG_OFFSET_CAPTURE);
            foreach ($matches[0] as $match) {
                $number = intval($match[0]);
                $rangeStart = max(0, $match[1] - 1);
                $rangeEnd = min(strlen($line), ($match[1]) + strlen($match[0]) + 1);
                if ($this->linesAndRangeHaveSymbols($lines, $lineIndex, $rangeStart, $rangeEnd)) {
                    $sum += $number;
                }
            }
        }

        return $sum;
    }

    public function linesAndRangeHaveSymbols(
        array $lines,
        int $middleLineIndex,
        int $rangeStart,
        int $rangeLength,
    ): bool {
        foreach (range($middleLineIndex - 1, $middleLineIndex + 1) as $lineIndex) {
            if (array_key_exists($lineIndex, $lines)) {
                if ($this->rangeHasSymbols($lines[$lineIndex], $rangeStart, $rangeLength)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param string $line
     * @param int $rangeStart
     * @param int $rangeEnd
     * @return boolean
     */
    public function rangeHasSymbols(
        string $line,
        int $rangeStart,
        int $rangeEnd
    ): bool {
        $substr = substr($line, $rangeStart, $rangeEnd - $rangeStart);
        return preg_match("/[^0-9.]/", $substr) === 1;
    }

    public function solve(): array
    {
        $input = $this->getInputString();

        return [
            "Part 1" => $this->solvePart1($input),
        ];
    }
}
