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
     * @return int
     */
    public function solvePart2(array $map): int
    {
        $newMap = $map;
        $cycle = 0;
        $mapHashes = [];
        while (true) {
            $cycledMap = $this->cycle($newMap);
            $cycle += 1;

            $newMapHash = md5(serialize($newMap));
            $cycledMapHash = md5(serialize($cycledMap));

            $mapHashes[$newMapHash] = [
                'mappedHash' => $cycledMapHash,
                'cycle' => $cycle,
                'load' => $this->computeLoad($newMap)
            ];
            $newMap = $cycledMap;
            if ($this->hasRepeatingCycle($mapHashes)) {
                break;
            }
        }
        return $this->getLoadAtCycle($mapHashes, 1000000000);
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

    /**
     * @param string[] $map
     * @return string[]
     */
    public function cycle(array $map): array
    {
        $height = count($map);
        $width = strlen($map[0]);
        // Tilt north
        $map = $this->tiltNorth($map);
        // Tilt east
        foreach (range(0, $width - 1) as $x) {
            foreach (range(0, $height - 1) as $y) {
                if ($map[$y][$x] !== 'O') {
                    continue;
                }
                $x2 = $x;
                while (true) {
                    $x2 -= 1;
                    if ($x2 === -1 || $map[$y][$x2] !== '.') {
                        if ($x2 + 1 !== $x) {
                            $map[$y][$x] = '.';
                            $map[$y][$x2 + 1] = 'O';
                        }
                        break;
                    }
                }
            }
        }
        // Tilt south
        foreach (range($height - 1, 0, -1) as $y) {
            foreach (range(0, $width - 1) as $x) {
                if ($map[$y][$x] !== 'O') {
                    continue;
                }
                $y2 = $y;
                while (true) {
                    $y2 += 1;
                    if ($y2 === $height || $map[$y2][$x] !== '.') {
                        if ($y2 - 1 !== $y) {
                            $map[$y][$x] = '.';
                            $map[$y2 - 1][$x] = 'O';
                        }
                        break;
                    }
                }
            }
        }
        // Tilt west
        foreach (range($width - 1, 0, -1) as $x) {
            foreach (range(0, $height - 1) as $y) {
                if ($map[$y][$x] !== 'O') {
                    continue;
                }
                $x2 = $x;
                while (true) {
                    $x2 += 1;
                    if ($x2 === $width || $map[$y][$x2] !== '.') {
                        if ($x2 - 1 !== $x) {
                            $map[$y][$x] = '.';
                            $map[$y][$x2 - 1] = 'O';
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
     * @param array{mappedHash: string, cycle: int, load: int}[] $cycleHashMap
     * @return bool
     */
    public function hasRepeatingCycle(array $cycleHashMap): bool
    {
        foreach (array_keys($cycleHashMap) as $hash) {
            if (count(array_filter($cycleHashMap, fn($mappedCycle2) => $mappedCycle2['mappedHash'] === $hash)) > 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array{mappedHash: string, cycle: int, load: int}[] $cycleHashMap
     * @param int $atCycle
     * @return int
     */
    public function getLoadAtCycle(array $cycleHashMap, int $atCycle): int
    {
        $startOfLoopHash = null;
        $nextLoopHash = null;
        $loadValues = [];
        foreach (array_keys($cycleHashMap) as $hash) {
            if (count(array_filter($cycleHashMap, fn($mappedCycle2) => $mappedCycle2['mappedHash'] === $hash)) > 1) {
                $startOfLoopHash = $hash;
                break;
            }
        }

        $startOfLoopCycle = $cycleHashMap[$startOfLoopHash]['cycle'];

        while ($nextLoopHash !== $startOfLoopHash) {
            if ($nextLoopHash === null) {
                $nextLoopHash = $startOfLoopHash;
            }
            $loadValues[] = $cycleHashMap[$nextLoopHash]['load'];
            $nextLoopHash = $cycleHashMap[$nextLoopHash]['mappedHash'];
        }

        return $loadValues[($atCycle - $startOfLoopCycle + 1) % count($loadValues)];
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
            "Part 2" => $this->solvePart2($puzzle),
        ];
    }
}
