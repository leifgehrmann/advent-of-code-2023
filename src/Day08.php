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
     * @param Puzzle $puzzle
     * @return int|string
     */
    public function solvePart2(array $puzzle): int|string
    {
        // Unsure if this works for all inputs from advent of code, but at
        // least in my input I discovered that all the "ghosts" end up in
        // a 'Z' room on the 281st instruction, just at different steps.

        // I also noticed that when running the code for the first 100,000
        // steps, the ghosts end up in a 'Z' room at a regular interval.
        // This sounds like a least-common-multiple problem.

        $startPositions = array_filter(array_keys($puzzle['nodePaths']), function ($path) {
            return str_ends_with($path, 'A');
        });
        $positionsData = [];
        foreach ($startPositions as $startPosition) {
            $positionsData[] = [
                'position' => $startPosition,
                'stepsWhenZWasHit' => [],
                'instructionIndexWhenZWasHit' => [],
            ];
        }

        $steps = 0;
        while (true) {
            foreach (str_split($puzzle['instructions']) as $instructionIndex => $instruction) {
                $steps += 1;
                foreach ($positionsData as $positionDataIndex => $positionData) {
                    $oldPosition = $positionData['position'];
                    $newPosition = match ($instruction) {
                        'L' => $puzzle['nodePaths'][$oldPosition][0],
                        'R' => $puzzle['nodePaths'][$oldPosition][1],
                        default => 'AAA',
                    };
                    if (str_ends_with($newPosition, 'Z')) {
                        $positionsData[$positionDataIndex]['stepsWhenZWasHit'][] = $steps;
                        $positionsData[$positionDataIndex]['instructionIndexWhenZWasHit'][] = $instructionIndex;
                    }
                    $positionsData[$positionDataIndex]['position'] = $newPosition;
                }

                $allRoomsAreZ = true;
                foreach ($positionsData as $positionData) {
                    if (!str_ends_with($positionData['position'], 'Z')) {
                        $allRoomsAreZ = false;
                        break;
                    }
                }

                if ($allRoomsAreZ) {
                    return $steps;
                }
            }

            // Only use least-common-multiples if we are over 100 steps in.
            if ($steps > 100) {
                // Break the loop once every ghost has reached a 'Z' room at
                // least once.
                $allGhostsHaveReachedAZRoomOnce = true;
                foreach ($positionsData as $positionData) {
                    if (count($positionData['stepsWhenZWasHit']) === 0) {
                        $allGhostsHaveReachedAZRoomOnce = false;
                        break;
                    }
                }
                if ($allGhostsHaveReachedAZRoomOnce) {
                    break;
                }
            }
        }

        // Cool, now to compute least-common-multiples
        $numbers = array_map(fn ($data) => $data['stepsWhenZWasHit'][0] ?? 0, $positionsData);

        // ... uhhh, actually, let's use Wolfram Alpha shall we? 😅
        return 'https://www.wolframalpha.com/input?i=' . implode('%2C+', $numbers) . '+least+common+multiple';
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
            "Part 2" => $this->solvePart2($puzzle),
        ];
    }
}
