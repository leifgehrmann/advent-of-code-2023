<?php

namespace Aoc;

/**
 * @psalm-type     Race = array{
 *         time: int,
 *         distance: int,
 *    }
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day06 extends AbstractDay
{
    /**
     * @param Race[] $puzzle
     * @return int
     */
    public function solvePart1(array $puzzle): int
    {
        $product = 1;
        foreach ($puzzle as $race) {
            $product *= $this->countRecordsThatBeat($race['time'], $race['distance']);
        }
        return $product;
    }

    /**
     * @param Race $race
     * @return int
     */
    public function solvePart2(array $race): int
    {
        return $this->countRecordsThatBeat($race['time'], $race['distance']);
    }

    public function countRecordsThatBeat(int $time, int $distanceToBeat): int
    {
        // This can be computed by thinking the problem as the intersection of
        // two functions:
        // y = (-x) * (x - $time)
        // y = $distanceToBeat
        // In other words:
        // 0 = -x^2 - $time * x - $distanceToBeat
        //
        // We want to solve for the roots of the equation, which we can do
        // using the quadratic formula.
        // x = (-b ± sqrt(b^2 - 4 * a * c)) / 2a

        $discriminant = sqrt($time * $time - 4 * $distanceToBeat);

        if (is_nan($discriminant)) {
            // This means we have an imaginary number, which means it's not possible to beat the race.
            return 0;
        }
        $rootSmall = (-$time + $discriminant) / -2;
        $rootLarge = (-$time - $discriminant) / -2;

        // Now we know the roots, we just compute all the natural numbers
        // between the two intersections.
        $shortestTimeToWait = (int)ceil($rootSmall);
        $longestTimeToWait = (int)floor($rootLarge);
        $range = $longestTimeToWait - $shortestTimeToWait + 1; // (Add 1 because it's an inclusive range)

        // Do not include instances where it's a tie.
        if ($shortestTimeToWait == $rootSmall) {
            $range -= 1;
        }
        if ($longestTimeToWait == $rootLarge) {
            $range -= 1;
        }
        return $range;
    }

    /**
     * @param string $input
     * @return Race[]
     */
    public function parsePuzzle(string $input): array
    {
        preg_match_all('/[0-9]+/m', $input, $matches);

        $races = [];
        $chunks = array_chunk($matches[0], (int)(count($matches[0]) / 2));
        for ($i = 0; $i < count($chunks[0]); $i++) {
            $races[] = [
                'time' => intval($chunks[0][$i]),
                'distance' => intval($chunks[1][$i]),
            ];
        }
        return $races;
    }

    /**
     * @param string $input
     * @return array
     */
    public function parsePuzzleForPart2(string $input): array
    {
        preg_match_all('/[0-9]+/m', $input, $matches);

        $chunks = array_chunk($matches[0], (int)(count($matches[0]) / 2));
        return [
            'time' => intval(join('', $chunks[0])),
            'distance' => intval(join('', $chunks[1])),
        ];
    }

    public function solve(): array
    {
        $puzzleForPart1 = $this->parsePuzzle($this->getInputString());
        $puzzleForPart2 = $this->parsePuzzleForPart2($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($puzzleForPart1),
            "Part 2" => $this->solvePart2($puzzleForPart2),
        ];
    }
}
