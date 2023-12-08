<?php

namespace Aoc;

/**
 * @psalm-type     Puzzle = array{
 *         instructions: string,
 *         nodePaths: array<string, array{0: string, 1: string}>,
 *    }
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day08 extends AbstractDay
{
    /**
     * @param Puzzle $puzzle
     * @return int
     */
    public function solvePart1(array $puzzle): int
    {
        $position = 'AAA';
        $steps = 0;
        while (true) {
            foreach (str_split($puzzle['instructions']) as $instruction) {
                if ($position === 'ZZZ') {
                    return $steps;
                }
                $position = match ($instruction) {
                    'L' => $puzzle['nodePaths'][$position][0],
                    'R' => $puzzle['nodePaths'][$position][1],
                    default => 'AAA',
                };
                $steps += 1;
            }
        }
    }

    /**
     * @param string $input
     * @return Puzzle
     */
    public function parsePuzzle(string $input): array
    {
        $parts = explode("\n\n", $input);

        $lines = explode("\n", str_replace(['=', '(', ')', ','], '', $parts[1]));
        $nodePaths = [];
        foreach ($lines as $line) {
            $splitLine = explode(' ', $line);
            $nodePaths[$splitLine[0]] = [
                $splitLine[2],
                $splitLine[3],
            ];
        }

        return [
            'instructions' => $parts[0],
            'nodePaths' => $nodePaths,
        ];
    }

    public function solve(): array
    {
        $puzzle = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($puzzle),
        ];
    }
}
