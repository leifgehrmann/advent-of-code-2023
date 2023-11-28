<?php

namespace Aoc;

use Exception;

class App
{
    /**
     * @param string[] $argv
     * @return void
     * @throws Exception
     */
    public function run(array $argv): void
    {
        $day = $this->getDayFromArgv($argv);
        $runBenchmarks = $this->getRunBenchmarksFromArgv($argv);
        $benchmarkAttempts = 10;

        if (!$runBenchmarks) {
            if ($day !== null) {
                $this->solveForSpecificDay($day);
            } else {
                $this->solveAll();
            }
        } else {
            if ($day !== null) {
                $this->runBenchmarksForSpecificDay($day, $benchmarkAttempts);
            } else {
                $this->runBenchmarksAll($benchmarkAttempts);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function solveForSpecificDay(int $day): void
    {
        $dayString = sprintf('%02d', $day);
        $className = "Aoc\Day$dayString";
        echo "Day $dayString:\n";
        if (!class_exists($className)) {
            echo " - Not implemented\n";
            return;
        }
        $dayPuzzle = new $className();
        assert($dayPuzzle instanceof AbstractDay);
        $solutions = $dayPuzzle->solve();
        $this->printSolution($solutions);
    }

    /**
     * @throws Exception
     */
    private function runBenchmarksForSpecificDay(int $day, int $attempts): void
    {
        $dayString = sprintf('%02d', $day);
        $className = "Aoc\Day$dayString";
        echo "Day $dayString:\n";
        if (!class_exists($className)) {
            echo " - Not implemented\n";
            return;
        }
        $dayPuzzle = new $className();
        assert($dayPuzzle instanceof AbstractDay);

        $totalDuration = 0;
        foreach (range(1, $attempts) as $attempt) {
            $start = microtime(true);
            $dayPuzzle->solve();
            $end = microtime(true);
            $duration = number_format($end - $start, 6);
            echo " - Attempt $attempt duration: {$duration}s\n";
            $totalDuration += $end - $start;
        }
        $averageDuration = number_format($totalDuration / $attempts, 6);
        echo " - Average duration: {$averageDuration}s\n";
    }

    private function solveAll(): void
    {
        for ($day = 1; $day <= 25; $day += 1) {
            $this->solveForSpecificDay($day);
        }
        echo "\n";
    }

    /**
     * @throws Exception
     */
    private function runBenchmarksAll(int $attempts): void
    {
        for ($day = 1; $day <= 25; $day += 1) {
            $this->runBenchmarksForSpecificDay($day, $attempts);
        }
        echo "\n";
    }

    private function printSolution(array $solutions): void
    {
        $output = '';
        foreach ($solutions as $solutionKey => $solution) {
            $output .= ' - ';
            if (is_string($solutionKey)) {
                $output .= "$solutionKey: ";
            }
            $output .= "$solution\n";
        }
        print $output;
    }

    /**
     * @param string[] $argv
     * @return int|null
     */
    private function getDayFromArgv(array $argv): ?int
    {
        foreach ($argv as $arg) {
            if (is_numeric($arg)) {
                return intval($arg);
            }
        }
        return null;
    }

    /**
     * @param string[] $argv
     * @return bool
     */
    private function getRunBenchmarksFromArgv(array $argv): bool
    {
        return in_array('-b', $argv);
    }
}
