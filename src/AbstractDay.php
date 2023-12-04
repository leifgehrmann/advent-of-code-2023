<?php

namespace Aoc;

abstract class AbstractDay
{
    /**
     * Returns the solutions for the day's puzzle, in parts. This might either
     * be a string or an integer.
     *
     * @return (string|int)[]
     */
    abstract public function solve(): array;

    /**
     * Returns the contents of the .data file for the respective day.
     *
     * @return string
     */
    protected function getInputString(): string
    {
        $className = get_class($this);
        preg_match('/Day\d\d?/', $className, $matches);
        $contents = file_get_contents(__DIR__ . "/$matches[0].data");
        if (is_bool($contents)) {
            throw new \RuntimeException(
                "Failed to read contents of " . __DIR__ . "/$matches[0].data"
            );
        }
        return $contents;
    }
}
