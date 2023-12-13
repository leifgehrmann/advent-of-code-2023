<?php

namespace Aoc;

/**
 * @psalm-type     Groups = int[]
 * @psalm-type     Puzzle = array{line: string, groups: Groups}[]
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
            $pattern = $this->buildPattern($item['groups']);
            $sum += $this->countArrangements($item['line'], $pattern);
        }
        return $sum;
    }

    public function solvePart2(array $puzzle): int
    {
        $sum = 0;
        foreach ($puzzle as $i => $item) {
            echo "$i\n";
            $newLine = join('?', array_fill(0, 5, $item['line']));
            $newGroups = array_merge(...array_fill(0, 5, $item['groups']));
            $newPattern = $this->buildPattern($newGroups);
            $sum += $this->countArrangements($newLine, $newPattern);
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
        if (!$this->matchesLine($line, $pattern)) {
            return 0;
        }

        $questionPos = strpos($line, '?');
        if ($questionPos === false) {
            return 1;
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
            $output[] = [
                'line' => $line,
                'groups' => $groups
            ];
        }
        return $output;
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
