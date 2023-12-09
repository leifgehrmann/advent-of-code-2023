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
     * @return int
     */
    public function solvePart1(array $puzzle): int
    {
        $sum = 0;
        foreach ($puzzle as $history) {
            $sum += $this->calculateNextHistoryValue($history);
        }
        return $sum;
    }

    /**
     * @param array<int> $history
     * @return int
     */
    public function calculateNextHistoryValue(array $history): int
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
        }
        return end($allDerivatives[0]);
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

        return [
            "Part 1" => $this->solvePart1($puzzle),
        ];
    }
}
