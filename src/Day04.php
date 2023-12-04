<?php

namespace Aoc;

use Exception;

/**
 * @psalm-type Card = array{
 *        id: int,
 *        winningNumbers: list<int>,
 *        selectedNumbers: list<int>,
 *   }
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day04 extends AbstractDay
{
    /**
     * @param Card[] $cards
     * @return int
     */
    public function solvePart1(array $cards): int
    {
        $sum = 0;
        foreach ($cards as $card) {
            $sum += $this->scoreCard($card);
        }
        return $sum;
    }

    /**
     * @param Card[] $cards
     * @return int
     */
    public function solvePart2(array $cards): int
    {
        $instancesOfCards = [];
        foreach ($cards as $card) {
            $instancesOfCards[$card['id']] = 1;
        }
        foreach ($cards as $card) {
            $instancesOfCard = $instancesOfCards[$card['id']];
            $matches = $this->countMatches($card);
            if ($matches == 0) {
                continue;
            }
            $nextCardRangeStart = $card['id'] + 1;
            $nextCardRangeEnd = $card['id'] + $matches;
            foreach (range($nextCardRangeStart, $nextCardRangeEnd) as $nextCardId) {
                $instancesOfCards[$nextCardId] += $instancesOfCard;
            }
        }
        return array_sum($instancesOfCards);
    }

    /**
     * @param string $cardString
     * @return Card
     */
    public function parseCardString(string $cardString): array
    {
        $re = '/Card *(?<id>[0-9]+): +(?P<winningNumbers>[0-9 ]+) \| +(?P<selectedNumbers>[0-9 ]+)/';
        preg_match($re, $cardString, $matches);
        $id = intval($matches['id']);
        $winningNumbers = array_map(
            fn ($int) => intval($int),
            explode(' ', str_replace('  ', ' ', $matches['winningNumbers']))
        );
        $selectedNumbers = array_map(
            fn ($int) => intval($int),
            explode(' ', str_replace('  ', ' ', $matches['selectedNumbers']))
        );
        return [
            'id' => $id,
            'winningNumbers' => $winningNumbers,
            'selectedNumbers' => $selectedNumbers,
        ];
    }

    /**
     * @param Card $card
     * @return int
     */
    public function scoreCard(array $card): int
    {
        $score = 0;
        foreach ($card['winningNumbers'] as $winningNumber) {
            if (in_array($winningNumber, $card['selectedNumbers'])) {
                if ($score === 0) {
                    $score += 1;
                } else {
                    $score *= 2;
                }
            };
        }
        return $score;
    }

    /**
     * @param Card $card
     * @return int
     */
    public function countMatches(array $card): int
    {
        $matches = 0;
        foreach ($card['winningNumbers'] as $winningNumber) {
            if (in_array($winningNumber, $card['selectedNumbers'])) {
                $matches += 1;
            };
        }
        return $matches;
    }

    public function solve(): array
    {
        $cardStrings = explode("\n", $this->getInputString());
        $cards = array_map(fn($cardString) => $this->parseCardString($cardString), $cardStrings);

        return [
            "Part 1" => $this->solvePart1($cards),
            "Part 2" => $this->solvePart2($cards),
        ];
    }
}
