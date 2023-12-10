<?php

namespace Aoc;

use RuntimeException;

/**
 * @psalm-type     Map = non-empty-array<string>
 * @psalm-type     Position = array{x: int, y: int}
 * @psalm-type     Movement = array{x: int, y: int, fromDirection: Day10::FROM_* }
 *
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day10 extends AbstractDay
{
    public const FROM_TOP = 1;
    public const FROM_BOTTOM = 2;
    public const FROM_LEFT = 3;
    public const FROM_RIGHT = 4;

    /**
     * @param Map $map
     * @return int
     */
    public function solvePart1(array $map): int
    {
        $steps = 1;
        $startPosition = $this->getStartPosition($map);
        $movement = $this->getStartMovement($map, $startPosition);
        while ($startPosition['x'] !== $movement['x'] || $startPosition['y'] !== $movement['y']) {
            $pipe = $this->getPipe($map, $movement);
            $movement = $this->getNextMovement($movement, $pipe);
            $steps += 1;
        }
        return (int) ($steps / 2);
    }

    /**
     * @param Map $map
     * @return Position
     */
    public function getStartPosition(array $map): array
    {
        foreach ($map as $lineIndex => $line) {
            $startPosition = strpos($line, 'S');
            if ($startPosition !== false) {
                return ['x' => $startPosition, 'y' => $lineIndex];
            }
        }

        throw new RuntimeException('No start position S found in input');
    }

    /**
     * @param Map $map
     * @param Position $startPosition
     * @return Movement
     */
    public function getStartMovement(array $map, array $startPosition): array
    {
        /** @var array{ dx: int, dy: int, dir: Day10::FROM_*, validPipes: string[]}[] $deltaMovements */
        $deltaMovements = [
            ['dx' =>  1, 'dy' => 0,  'dir' => self::FROM_LEFT,   'validPipes' => ['-', '7', 'J']],
            ['dx' =>  0, 'dy' => 1,  'dir' => self::FROM_TOP,    'validPipes' => ['|', 'L', 'J']],
            ['dx' => -1, 'dy' => 0,  'dir' => self::FROM_RIGHT,  'validPipes' => ['-', 'F', 'L']],
            ['dx' =>  0, 'dy' => -1, 'dir' => self::FROM_BOTTOM, 'validPipes' => ['|', 'F', '7']]
        ];
        foreach ($deltaMovements as $deltaMovement) {
            $movementPosition = [
                'x' => $startPosition['x'] + $deltaMovement['dx'],
                'y' => $startPosition['y'] + $deltaMovement['dy'],
            ];
            $pipe = $this->getPipe($map, $movementPosition);
            if (!in_array($pipe, $deltaMovement['validPipes'])) {
                continue;
            }
            return [
                'x' => $movementPosition['x'],
                'y' => $movementPosition['y'],
                'fromDirection' => $deltaMovement['dir'],
            ];
        }

        throw new RuntimeException('No valid pipes are connected to the start position');
    }

    /**
     * @param Map $map
     * @param Position|Movement $position
     * @return string
     */
    public function getPipe(array $map, array $position): string
    {
        return $map[$position['y']][$position['x']];
    }

    /**
     * @param Movement $previousMovement
     * @param string $pipe
     * @return Movement
     */
    public function getNextMovement(array $previousMovement, string $pipe): array
    {
        $x = $previousMovement['x'];
        $y = $previousMovement['y'];

        return match ($pipe) {
            '|' => match ($previousMovement['fromDirection']) {
                self::FROM_TOP => ['x' => $x, 'y' => $y + 1, 'fromDirection' => self::FROM_TOP],
                default =>        ['x' => $x, 'y' => $y - 1, 'fromDirection' => self::FROM_BOTTOM],
            },
            '-' => match ($previousMovement['fromDirection']) {
                self::FROM_LEFT => ['x' => $x + 1, 'y' => $y, 'fromDirection' => self::FROM_LEFT],
                default =>         ['x' => $x - 1, 'y' => $y, 'fromDirection' => self::FROM_RIGHT],
            },
            'F' => match ($previousMovement['fromDirection']) {
                self::FROM_BOTTOM => ['x' => $x + 1, 'y' => $y, 'fromDirection' => self::FROM_LEFT],
                default =>           ['x' => $x, 'y' => $y + 1, 'fromDirection' => self::FROM_TOP],
            },
            'L' => match ($previousMovement['fromDirection']) {
                self::FROM_TOP => ['x' => $x + 1, 'y' => $y, 'fromDirection' => self::FROM_LEFT],
                default =>        ['x' => $x, 'y' => $y - 1, 'fromDirection' => self::FROM_BOTTOM],
            },
            'J' => match ($previousMovement['fromDirection']) {
                self::FROM_LEFT => ['x' => $x, 'y' => $y - 1, 'fromDirection' => self::FROM_BOTTOM],
                default =>         ['x' => $x - 1, 'y' => $y, 'fromDirection' => self::FROM_RIGHT],
            },
            '7' => match ($previousMovement['fromDirection']) {
                self::FROM_LEFT => ['x' => $x, 'y' => $y + 1, 'fromDirection' => self::FROM_TOP],
                default =>         ['x' => $x - 1, 'y' => $y, 'fromDirection' => self::FROM_RIGHT],
            },
            default =>
                throw new RuntimeException('Unexpected pipe type found')
        };
    }

    /**
     * @param Position|Movement $startPosition
     * @param Position|Movement $position
     * @return int
     */
    public function manhattanDistance(array $startPosition, array $position): int
    {
        return abs($startPosition['x'] - $position['x']) +
            abs($startPosition['y'] - $position['y']);
    }

    /**
     * @param string $input
     * @return Map
     */
    public function parsePuzzle(string $input): array
    {
        return explode("\n", $input);
    }

    public function solve(): array
    {
        $map = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($map),
        ];
    }
}
