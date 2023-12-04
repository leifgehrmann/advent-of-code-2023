<?php

namespace Aoc;

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

    /**
     * @param string $input
     * @return int
     */
    public function solvePart2(string $input): int
    {
        $lines = explode("\n", $input);

        $re = '/\*/m';

        $sum = 0;
        foreach ($lines as $lineIndex => $line) {
            $matches = [];
            preg_match_all($re, $line, $matches, PREG_OFFSET_CAPTURE);
            foreach ($matches[0] as $match) {
                $starIndex = $match[1];
                $numbers = $this->findAdjacentNumbers($lines, $lineIndex, $starIndex);
                if (count($numbers) === 2) {
                    // Todo: Too low
                    $sum += $numbers[0] * $numbers[1];
                }
            }
        }

        return $sum;
    }

    public function findAdjacentNumbers(array $lines, int $middleLineIndex, int $starIndex): array
    {
        $numbers = [];
        foreach (range($middleLineIndex - 1, $middleLineIndex + 1) as $lineIndex) {
            array_push($numbers, ...$this->searchNumberOnLineFromPosition($lines[$lineIndex], $starIndex));
        }
        return $numbers;
    }

    public function searchNumberOnLineFromPosition(string $line, int $index): array
    {
        if (is_numeric($line[$index])) {
            // This must mean only one number exists on the same line, and no
            // more than two can appear.
            return [$this->lookLeftAndRightForNumber($line, $index)];
        }
        $numbers = [];
        if ($index - 1 >= 0 && is_numeric($line[$index - 1])) {
            $numbers[] = $this->lookLeftAndRightForNumber($line, $index - 1);
        }
        if ($index + 1 < strlen($line) && is_numeric($line[$index + 1])) {
            $numbers[] = $this->lookLeftAndRightForNumber($line, $index + 1);
        }

        return $numbers;
    }

    public function lookLeftAndRightForNumber(string $line, int $index): int
    {
        $minIndex = $index;
        $maxIndex = $index;
        while ($minIndex - 1 >= 0 && is_numeric($line[$minIndex - 1])) {
            $minIndex -= 1;
        }
        while ($maxIndex + 1 < strlen($line) && is_numeric($line[$maxIndex + 1])) {
            $maxIndex += 1;
        }
        return intval(substr($line, $minIndex, $maxIndex - $minIndex + 1));
    }

    public function solve(): array
    {
        $input = $this->getInputString();

        return [
            "Part 1" => $this->solvePart1($input),
            "Part 2" => $this->solvePart2($input),
        ];
    }
}
