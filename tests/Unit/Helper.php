<?php

namespace Aoc\Tests\Unit;

use PHPUnit\Framework\TestCase;

class Helper
{
    public static function getSampleData(string $filename): string
    {
        $contents = file_get_contents(__DIR__ . "/$filename");
        if (is_bool($contents)) {
            throw new \RuntimeException(
                "Failed to read contents of " . __DIR__ . "/$filename, " .
                "possible because it does not exist."
            );
        }
        if (str_contains($contents, 'GITCRYPT')) {
            TestCase::markTestSkipped(
                "Failed to read contents of " . __DIR__ . "/$filename, " .
                "probably because 'git-crypt unlock' has not been run. " .
                "See README.md for more detail."
            );
        }
        return $contents;
    }
}
