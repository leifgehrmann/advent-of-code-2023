<?php

namespace Aoc;

/**
 * @psalm-type     HandBid = array{
 *         hand: string,
 *         bid: int,
 *    }
 * The class is used, it's just called dynamically from App.php.
 * @psalm-suppress UnusedClass
 */
class Day07 extends AbstractDay
{
    public final const FIVE_OF_A_KIND = 5;
    public final const FOUR_OF_A_KIND = 4;
    public final const FULL_HOUSE = 3;
    public final const THREE_OF_A_KIND = 2;
    public final const TWO_PAIR = 1;
    public final const ONE_PAIR = 0;
    public final const HIGH_CARD = -1;

    /**
     * @param HandBid[] $puzzle
     * @return int
     */
    public function solvePart1(array $puzzle): int
    {
        usort($puzzle, function ($handBidA, $handBidB) {
            return $this->compareHand($handBidA['hand'], $handBidB['hand']);
        });
        $sum = 0;
        foreach ($puzzle as $order => $handBid) {
            $sum += ($order + 1) * $handBid['bid'];
        }
        return $sum;
    }

    public function compareHand(string $handA, string $handB): int
    {
        $handAType = $this->getHandType($handA);
        $handBType = $this->getHandType($handB);
        if ($handAType === $handBType) {
            return $this->compareHandStrength($handA, $handB);
        } elseif ($handAType > $handBType) {
            return 1;
        }
        return -1;
    }

    public function getHandType(string $hand): int
    {
        $counts = count_chars($hand);
        if (in_array(5, $counts)) {
            return self::FIVE_OF_A_KIND;
        } elseif (in_array(4, $counts)) {
            return self::FOUR_OF_A_KIND;
        } elseif (in_array(3, $counts) && in_array(2, $counts)) {
            return self::FULL_HOUSE;
        } elseif (in_array(3, $counts)) {
            return self::THREE_OF_A_KIND;
        } elseif (count(array_filter($counts)) === 3) {
            return self::TWO_PAIR;
        } elseif (in_array(2, $counts)) {
            return self::ONE_PAIR;
        }
        return self::HIGH_CARD;
    }

    public function compareHandStrength(string $handA, string $handB): int
    {
        for ($i = 0; $i < 5; $i++) {
            if ($handA[$i] === $handB[$i]) {
                continue;
            }
            if ($this->getCardStrength($handA[$i]) > $this->getCardStrength($handB[$i])) {
                return 1;
            }
            return -1;
        }
        return 0;
    }

    public function getCardStrength(string $card): int
    {
        return match ($card) {
            'A' => 14,
            'K' => 13,
            'Q' => 12,
            'J' => 11,
            'T' => 10,
            default => intval($card),
        };
    }

    /**
     * @return HandBid[]
     */
    public function parsePuzzle(string $input): array
    {
        return array_map(function ($line) {
            return [
                'hand' => substr($line, 0, 5),
                'bid' => intval(substr($line, 6)),
            ];
        }, explode("\n", $input));
    }

    public function solve(): array
    {
        $puzzle = $this->parsePuzzle($this->getInputString());

        return [
            "Part 1" => $this->solvePart1($puzzle),
        ];
    }
}
