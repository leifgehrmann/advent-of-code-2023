<?php

namespace Aoc;

use RuntimeException;

/**
 * @psalm-type     Groups = int[]
 * @psalm-type     Puzzle = array{line: string, groups: Groups, pattern: non-empty-string}[]
 *
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 * @psalm-suppress InvalidLiteralArgument
 */
class Day12 extends AbstractDay
{
    /**
     * @param Puzzle $puzzle
     * @return int
     */
    public function solvePart1(array $puzzle): int
    {
        $sum = 0;
        foreach ($puzzle as $item) {
            $sum += $this->countArrangements($item['line'], $item['pattern']);
        }
        return $sum;
    }

    /**
     * @param string $line
     * @param non-empty-string $pattern
     * @return int
     */
    public function countArrangements(string $line, string $pattern): int
    {
        $questionPos = strpos($line, '?');
        if ($questionPos === false) {
            if ($this->matchesLine($line, $pattern)) {
                return 1;
            }
            return 0;
        }

        $line[$questionPos] = '.';
        $lineA = $line;
        $line[$questionPos] = '#';
        $lineB = $line;
        return $this->countArrangements($lineA, $pattern) + $this->countArrangements($lineB, $pattern);
    }

    /**
     * @param string $line
     * @param non-empty-string $pattern
     * @return bool
     */
    public function matchesLine(string $line, string $pattern): bool
    {
        return preg_match($pattern, $line) === 1;
    }

    /**
     * @param Groups $groups
     * @return non-empty-string
     */
    public function buildPattern(array $groups): string
    {
        $dot = '[.?]';
        $hash = '[#?]';

        $pattern = "/^$dot*";
        $pattern .= join("$dot+", array_map(fn ($group) => "$hash{{$group}}", $groups));
        $pattern .= "$dot*$/";
        return $pattern;
    }

    /**
     * @param string $puzzle
     * @return Puzzle
     */
    public function parsePuzzle(string $puzzle): array
    {
        $inputs = explode("\n", $puzzle);
        $output = [];
        foreach ($inputs as $input) {
            list($line, $groupsStr) = explode(' ', $input);
            $groups = array_map(fn ($groupStr) => intval($groupStr), explode(',', $groupsStr));
            $pattern = $this->buildPattern($groups);
            $output[] = [
                'line' => $line,
                'groups' => $groups,
                'pattern' => $pattern,
            ];
        }
        return $output;
    }

    public function solve(): array
    {
        $map = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($map),
        ];
    }
}
