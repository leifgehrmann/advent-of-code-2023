<?php

namespace Aoc;

/**
 * @psalm-type     Map = array<string>
 * @psalm-type     Beam = array{x: int, y: int, dx: int, dy: int}
 * @psalm-type     Pos = array{x: int, y: int}
 *
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 * @psalm-suppress InvalidLiteralArgument
 */
class Day16 extends AbstractDay
{
    /**
     * @param string[] $map
     * @return int
     */
    public function solvePart1(array $map): int
    {
        $beam = ['x' => -1, 'y' => 0, 'dx' => 1, 'dy' => 0];
        return $this->computeEnergized($map, $beam);
    }

    /**
     * @param string[] $map
     * @return int
     */
    public function solvePart2(array $map): int
    {
        $maxEnergizedTiles = 0;
        $beamsToTest = [];
        foreach (range(0, count($map)) as $y) {
            $beamsToTest[] = ['x' => -1, 'y' => $y, 'dx' => 1, 'dy' => 0];
            $beamsToTest[] = ['x' => strlen($map[0]), 'y' => $y, 'dx' => -1, 'dy' => 0];
        }
        foreach (range(0, strlen($map[0])) as $x) {
            $beamsToTest[] = ['x' => $x, 'y' => -1, 'dx' => 0, 'dy' => 1];
            $beamsToTest[] = ['x' => $x, 'y' => count($map), 'dx' => 0, 'dy' => -1];
        }
        foreach ($beamsToTest as $beamToTest) {
            $maxEnergizedTiles = max($maxEnergizedTiles, $this->computeEnergized($map, $beamToTest));
        }
        return $maxEnergizedTiles;
    }

    /**
     * @param string[] $map
     * @param Beam $beam
     * @return int
     */
    public function computeEnergized(array $map, array $beam): int
    {
        $beams = [
            $beam,
        ];
        $energized = [];
        $resolvedBeams = [];

        while (count($beams) > 0) {
            $beam = array_pop($beams);
            $resolvedBeams[md5(serialize($beam))] = true;
            list('energizedPositions' => $energizedPositions, 'newBeams' => $newBeams) = $this->followBeam($beam, $map);
            foreach ($energizedPositions as $energizedPosition) {
                $energized[md5(serialize($energizedPosition))] = true;
            }
            foreach ($newBeams as $newBeam) {
                if (!array_key_exists(md5(serialize($newBeam)), $resolvedBeams)) {
                    $beams[] = $newBeam;
                }
            }
        }

        return count($energized);
    }

    /**
     * @param Beam $beam
     * @param Map $map
     * @return array{energizedPositions: Pos[], newBeams: Beam[]}
     *
     */
    public function followBeam(array $beam, array $map): array
    {
        $startX = $beam['x'];
        $startY = $beam['y'];
        $dx = $beam['dx'];
        $dy = $beam['dy'];
        $newX = $startX;
        $newY = $startY;

        $newBeams = [];
        $energized = [];

        while (true) {
            $newX += $dx;
            $newY += $dy;
            if (!$this->positionInMap($newX, $newY, $map)) {
                if ($startX === $newX - $dx && $startY === $newY - $dy) {
                    return ['energizedPositions' => [], 'newBeams' => []];
                }
                break;
            }
            $energized[] = ['x' => $newX, 'y' => $newY];
            $symbol = $map[$newY][$newX];
            // "If the beam encounters empty space (.), it continues in the
            // same direction."
            if ($symbol === '.') {
                continue;
            }
            // "If the beam encounters the pointy end of a splitter (| or -),
            // the beam passes through the splitter as if the splitter were
            // empty space."
            if (($symbol === '|' && $dx === 0) || ($symbol === '-' && $dy === 0)) {
                continue;
            }
            // "If the beam encounters a mirror (/ or \), the beam is
            // reflected 90 degrees depending on the angle of the mirror."
            if ($symbol === '/') {
                $newBeams[] = [
                    'x' => $newX,
                    'y' => $newY,
                    'dx' => -$dy,
                    'dy' => -$dx,
                ];
                break;
            }
            if ($symbol === '\\') {
                $newBeams[] = [
                    'x' => $newX,
                    'y' => $newY,
                    'dx' => $dy,
                    'dy' => $dx,
                ];
                break;
            }
            // "If the beam encounters the flat side of a splitter (| or -),
            // the beam is split into two beams going in each of the two
            // directions the splitter's pointy ends are pointing."
            if (($symbol === '|' && $dx !== 0) || ($symbol === '-' && $dy !== 0)) {
                $newBeams[] = [
                    'x' => $newX,
                    'y' => $newY,
                    'dx' => $dy,
                    'dy' => $dx,
                ];
                $newBeams[] = [
                    'x' => $newX,
                    'y' => $newY,
                    'dx' => -$dy,
                    'dy' => -$dx,
                ];
                break;
            }
        }

        return ['energizedPositions' => $energized, 'newBeams' => $newBeams];
    }

    /**
     * @param int $x
     * @param int $y
     * @param Map $map
     * @return bool
     */
    public function positionInMap(int $x, int $y, array $map): bool
    {
        return $x >= 0 && $y >= 0 && $x < strlen($map[0]) && $y < count($map);
    }

    /**
     * @param string $puzzle
     * @return Map
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
