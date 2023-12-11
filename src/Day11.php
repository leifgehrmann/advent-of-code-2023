<?php

namespace Aoc;

use RuntimeException;

/**
 * @psalm-type     Map = array<array<string>>
 * @psalm-type     Position = array{x: int, y: int}
 *
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 * @psalm-suppress InvalidLiteralArgument
 */
class Day11 extends AbstractDay
{
    /**
     * @param Map $map
     * @return int
     */
    public function solvePart1(array $map): int
    {
        $rowsAndColsToExpand = $this->getRowsAndColumnsToExpand($map);
        // Reverse so that we don't affect the indexes of previous rows/cols.
        $rows = array_reverse($rowsAndColsToExpand['rows']);
        $cols = array_reverse($rowsAndColsToExpand['cols']);
        foreach ($rows as $rowIndex) {
            $this->duplicateRow($map, $rowIndex);
        }
        foreach ($cols as $colIndex) {
            $this->duplicateCol($map, $colIndex);
        }

        $sum = 0;
        $positions = $this->getPositions($map);
        for ($p1 = 0; $p1 < count($positions); $p1++) {
            for ($p2 = $p1 + 1; $p2 < count($positions); $p2++) {
                if ($p1 === $p2) {
                    continue;
                }
                $sum += $this->calcDistance($positions[$p1], $positions[$p2]);
            }
        }
        return $sum;
    }

    /**
     * @param Map $map
     * @param int $expansion
     * @return int
     */
    public function solvePart2(array $map, int $expansion): int
    {
        $rowsAndColsToExpand = $this->getRowsAndColumnsToExpand($map);

        $sum = 0;
        $positions = $this->getPositions($map);
        for ($p1 = 0; $p1 < count($positions); $p1++) {
            for ($p2 = $p1 + 1; $p2 < count($positions); $p2++) {
                if ($p1 === $p2) {
                    continue;
                }
                $dist = $this->calcDistanceWithExpansion(
                    $positions[$p1],
                    $positions[$p2],
                    $rowsAndColsToExpand['rows'],
                    $rowsAndColsToExpand['cols'],
                    $expansion
                );
                $sum += $dist;
            }
        }
        return $sum;
    }

    /**
     * @param Map $map
     * @return array{rows: int[], cols: int[]}
     */
    public function getRowsAndColumnsToExpand(array $map): array
    {
        $rows = [];
        $cols = [];

        foreach ($map as $y => $row) {
            if (in_array('#', $row)) {
                continue;
            }
            $rows[] = $y;
        }

        for ($x = 0; $x < count($map[0]); $x++) {
            if (in_array('#', array_column($map, $x))) {
                continue;
            }
            $cols[] = $x;
        }

        return [
            'rows' => $rows,
            'cols' => $cols,
        ];
    }

    /**
     * @param Map $map
     * @param int $rowIndex
     * @return void
     */
    public function duplicateRow(array &$map, int $rowIndex): void
    {
        array_splice($map, $rowIndex, 0, [$map[$rowIndex]]);
    }

    /**
     * @param Map $map
     * @param int $colIndex
     * @return void
     */
    public function duplicateCol(array &$map, int $colIndex): void
    {
        for ($y = 0; $y < count($map); $y++) {
            array_splice($map[$y], $colIndex, 0, [$map[$y][$colIndex]]);
        }
    }

    /**
     * @param Map $map
     * @return Position[]
     */
    public function getPositions(array $map): array
    {
        $positions = [];
        for ($y = 0; $y < count($map); $y++) {
            for ($x = 0; $x < count($map[0]); $x++) {
                if ($map[$y][$x] === '#') {
                    $positions[] = ['x' => $x, 'y' => $y];
                }
            }
        }
        return $positions;
    }

    /**
     * @param Position $p1
     * @param Position $p2
     * @return int
     */
    public function calcDistance(array $p1, array $p2): int
    {
        return abs($p1['x'] - $p2['x']) + abs($p1['y'] - $p2['y']);
    }

    /**
     * @param Position $p1
     * @param Position $p2
     * @param array<int> $rowsToExpand
     * @param array<int> $colsToExpand
     * @param int $expansion
     * @return int
     */
    public function calcDistanceWithExpansion(
        array $p1,
        array $p2,
        array $rowsToExpand,
        array $colsToExpand,
        int $expansion,
    ): int {
        $minX = min($p1['x'], $p2['x']);
        $maxX = max($p1['x'], $p2['x']);
        $minY = min($p1['y'], $p2['y']);
        $maxY = max($p1['y'], $p2['y']);
        $deltaX = $maxX - $minX;
        $deltaY = $maxY - $minY;
        $spaceY = count(array_filter($rowsToExpand, fn($row) => $row > $minY && $row < $maxY));
        $spaceX = count(array_filter($colsToExpand, fn($col) => $col > $minX && $col < $maxX));

        return $spaceX * $expansion + ($deltaX - $spaceX) + $spaceY * $expansion + ($deltaY - $spaceY);
    }

    /**
     * @param string $input
     * @return Map
     */
    public function parsePuzzle(string $input): array
    {
        $lines = explode("\n", $input);
        return array_map(fn($line) => str_split($line), $lines);
    }

    public function solve(): array
    {
        $map = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($map),
            "Part 2" => $this->solvePart2($map, 1000000),
        ];
    }
}
