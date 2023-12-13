<?php

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 * @psalm-suppress InvalidLiteralArgument
 */
class Day13 extends AbstractDay
{
    /**
     * @param string[][] $maps
     * @return int
     */
    public function solvePart1(array $maps): int
    {
        $sum = 0;
        foreach ($maps as $map) {
            $mirrorOnRows = $this->findMirror($map);
            if ($mirrorOnRows !== null) {
                $sum += $mirrorOnRows * 100;
            }
            $newMap = $this->transposeMap($map);
            $mirrorOnCols = $this->findMirror($newMap);
            if ($mirrorOnCols !== null) {
                $sum += $mirrorOnCols;
            }
        }
        return $sum;
    }

    /**
     * @param string[] $map
     * @return int|null
     */
    public function findMirror(array $map): ?int
    {
        $minR = 0;
        $maxR = count($map) - 1;
        foreach (range($minR + 1, $maxR) as $r) {
            $lookBack = $r - 1;
            $lookNext = $r;
            while (true) {
                if ($lookBack < $minR || $lookNext > $maxR) {
                    return $r;
                }
                /** psalm-ignore PossiblyInvalidArrayOffset */
                if ($map[$lookBack] !== $map[$lookNext]) {
                    break;
                }
                $lookBack -= 1;
                $lookNext += 1;
            }
        }
        return null;
    }

    /**
     * @param string[] $map
     * @return string[]
     */
    public function transposeMap(array $map): array
    {
        $cols = strlen($map[0]);
        $newMap = [];
        foreach (range(0, $cols - 1) as $c) {
            $newMap[] = join('', array_map(fn($row) => $row[$c], $map));
        }
        return $newMap;
    }

    /**
     * @param string $puzzle
     * @return string[][]
     */
    public function parsePuzzle(string $puzzle): array
    {
        $mapsStr = explode("\n\n", $puzzle);
        $maps = [];
        foreach ($mapsStr as $mapStr) {
            $maps[] = explode("\n", $mapStr);
        }
        return $maps;
    }

    public function solve(): array
    {
        $puzzle = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($puzzle),
            // "Part 2" => $this->solvePart2($puzzle),
        ];
    }
}
