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

    public function solvePart2(array $map): int
    {
        // The only way I know of how to check whether a point is within or
        // outside a shape is the ray-casting algorithm. This is done by
        // counting the number of intersections for each "edge". If the number
        // of intersections is odd, then the position is inside the shape.
        // See https://en.wikipedia.org/wiki/Point_in_polygon#Ray_casting_algorithm

        // For example, let say we have the line, with pipes that are all
        // part of the loop:
        // ...|.|..F-J.L-7.|.L-7.F7.L--J.L-7.|.|.|.
        //
        // Using the ray casting algorithm, we want to measure even/odd
        // intersections like so:
        // ...|.|..F-J.L-7.|.L-7.F7.L--J.L-7.|.|.|.
        // EEEOOEEEOOOOOOEEOOEEOOEOOEEEOOEEOOEEOOEE
        //    |X|  F-JXL-7 |XL-7XF7XL--JXL-7X| |X|
        //     X      X     X   X  X    X   X   X = 7

        // From the example above, it appears that we need to handle special
        // edge cases like:
        // - | counts as one edge
        // - F-*J is one edge
        // - L-*7 is one edge
        // - L-*J are two edges
        // - F-*7 are two edges

        // So first, we want to get all the segments for each row that are part of
        // the loop, indexed by each line.
        $startPosition = $this->getStartPosition($map);
        $movement = $this->getStartMovement($map, $startPosition);
        $pipesPartOfTheLoop = [$startPosition, $movement];
        while ($startPosition['x'] !== $movement['x'] || $startPosition['y'] !== $movement['y']) {
            $pipe = $this->getPipe($map, $movement);
            $movement = $this->getNextMovement($movement, $pipe);
            $pipesPartOfTheLoop[] = $movement;
        }

        /** @var Map $pipelineMap */
        $pipelineMap = array_fill(0, count($map), str_pad('', strlen($map[0]), ' '));
        foreach ($pipesPartOfTheLoop as $pipePosition) {
            $pipelineMap[$pipePosition['y']][$pipePosition['x']] = $this->getPipe($map, $pipePosition);
        }

        // Our algorithm won't work if the letter S is in the puzzle... So
        // let's write some lazy code that replaces the pipe with an actual pipe.
        $startPipe = $this->deriveStartPipe($pipelineMap, $startPosition);
        $pipelineMap[$startPosition['y']][$startPosition['x']] = $startPipe;

        $totalHoles = 0;
        foreach ($pipelineMap as $pipelineMapLine) {
            $intersections = 0;
            $holesForLine = 0;
            $lastTurn = ' ';
            foreach (str_split($pipelineMapLine) as $pipe) {
                if ($pipe === ' ') {
                    if ($intersections % 2 === 1) {
                        $totalHoles += 1;
                        $holesForLine += 1;
                    }
                } elseif ($pipe === '|') {
                    $intersections += 1;
                } elseif ($pipe === '-') {
                    continue;
                } elseif ($pipe === 'J') {
                    if ($lastTurn === 'F') {
                        $intersections += 1;
                    }
                } elseif ($pipe === '7') {
                    if ($lastTurn === 'L') {
                        $intersections += 1;
                    }
                } elseif ($pipe === 'L') {
                    $lastTurn = $pipe;
                } elseif ($pipe === 'F') {
                    $lastTurn = $pipe;
                }
            }

            echo "$pipelineMapLine = $holesForLine\n";
        }

        return $totalHoles;
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
     * @param Map $map
     * @param Position $startPosition
     * @return string
     */
    public function deriveStartPipe(array $map, array $startPosition): string
    {
        // Half implemented, it only works for the provided input example and
        $x = $startPosition['x'];
        $y = $startPosition['y'];
        if ($map[$y + 1][$x] === '|' && $map[$y][$x + 1] === '-') {
            return 'F';
        } elseif ($map[$y + 1][$x] === '|' && $map[$y][$x - 1] === 'F') {
            return '7';
        } elseif ($map[$y + 1][$x] === 'J' && $map[$y][$x + 1] === '7') {
            return 'F';
        } elseif ($map[$y - 1][$x] === '|' && $map[$y + 1][$x] === '|') {
            return '|';
        }
        throw new RuntimeException('Please update deriveStartPipe to work with your input!');
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
            "Part 2" => $this->solvePart2($map),
        ];
    }
}
