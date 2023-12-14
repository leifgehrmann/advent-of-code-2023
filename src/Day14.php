<?php

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 * @psalm-suppress InvalidLiteralArgument
 */
class Day14 extends AbstractDay
{
    /**
     * @param string[] $map
     * @return int
     */
    public function solvePart1(array $map): int
    {
        $newMap = $this->tiltNorth($map);
        return $this->computeLoad($newMap);
    }

    /**
     * @param string[] $map
     * @return string[]
     */
    public function tiltNorth(array $map): array
    {
        $height = count($map);
        $width = strlen($map[0]);
        foreach (range(0, $height - 1) as $y) {
            foreach (range(0, $width - 1) as $x) {
                if ($map[$y][$x] !== 'O') {
                    continue;
                }
                $y2 = $y;
                while (true) {
                    $y2 -= 1;
                    if ($y2 === -1 || $map[$y2][$x] !== '.') {
                        if ($y2 + 1 !== $y) {
                            $map[$y][$x] = '.';
                            $map[$y2 + 1][$x] = 'O';
                        }
                        break;
                    }
                }
            }
        }
        return $map;
    }

    public function computeLoad(array $map): int
    {
        $sum = 0;
        $totalLines = count($map);
        foreach ($map as $i => $line) {
            $sum += substr_count($line, 'O') * ($totalLines - intval($i));
        }
        return $sum;
    }

    /**
     * @param string $puzzle
     * @return string[]
     */
    public function parsePuzzle(string $puzzle): array
    {
        return explode("\n", $puzzle);
    }

    public function solve(): array
    {
        $puzzle = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($puzzle),
        ];
    }
}
