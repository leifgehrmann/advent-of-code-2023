<?php

namespace Aoc;

/**
 * @psalm-type     Puzzle = non-empty-array<non-empty-array<int>>
 *
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day09 extends AbstractDay
{
    /**
     * @param Puzzle $puzzle
     * @return array{nextSum: int, previousSum: int}
     */
    public function solvePart1AndPart2(array $puzzle): array
    {
        $nextSum = 0;
        $previousSum = 0;
        foreach ($puzzle as $history) {
            $nextSum += $this->calculateNextAndPreviousHistoryValues($history)['next'];
            $previousSum += $this->calculateNextAndPreviousHistoryValues($history)['previous'];
        }
        return [
            'nextSum' => $nextSum,
            'previousSum' => $previousSum,
        ];
    }

    /**
     * @param array<int> $history
     * @return array{next: int, previous: int}
     */
    public function calculateNextAndPreviousHistoryValues(array $history): array
    {
        $allDerivatives = [$history];
        $lastDerivatives = $history;
        $derivativesAllIdentical = false;
        while (!$derivativesAllIdentical) {
            $result = $this->calculateDerivativeOfHistory($lastDerivatives);
            $lastDerivatives = $result['derivatives'];
            $allDerivatives[] = $result['derivatives'];
            $derivativesAllIdentical = $result['allIdentical'];
        }

        for ($i = count($allDerivatives) - 1; $i > 0; $i--) {
            $allDerivatives[$i - 1][] = end($allDerivatives[$i - 1]) + end($allDerivatives[$i]);
            array_unshift($allDerivatives[$i - 1], $allDerivatives[$i - 1][0] - $allDerivatives[$i][0]);
        }
        return [
            'next' => end($allDerivatives[0]),
            'previous' => $allDerivatives[0][0],
        ];
    }

    /**
     * @param array<int> $history
     * @return array{derivatives: array<int>, allIdentical: bool}
     */
    public function calculateDerivativeOfHistory(array $history): array
    {
        $allIdentical = true;
        $prevDerivative = null;
        $derivatives = [];
        for ($i = 1; $i < count($history); $i++) {
            $derivative = $history[$i] - $history[$i - 1];
            $derivatives[] = $history[$i] - $history[$i - 1];
            if ($prevDerivative !== null && $prevDerivative !== $derivative) {
                $allIdentical = false;
            }
            $prevDerivative = $derivative;
        }

        return [
            'derivatives' => $derivatives,
            'allIdentical' => $allIdentical,
        ];
    }

    /**
     * @param string $input
     * @return Puzzle
     */
    public function parsePuzzle(string $input): array
    {
        return array_map(
            fn($line) => array_map(
                fn($val) => intval($val),
                explode(' ', $line)
            ),
            explode("\n", $input)
        );
    }

    public function solve(): array
    {
        $puzzle = $this->parsePuzzle($this->getInputString());
        $output = $this->solvePart1AndPart2($puzzle);

        return [
            "Part 1" => $output['nextSum'],
            "Part 2" => $output['previousSum'],
        ];
    }
}
