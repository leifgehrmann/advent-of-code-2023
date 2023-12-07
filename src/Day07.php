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

    /**
     * @param HandBid[] $puzzle
     * @return int
     */
    public function solvePart2(array $puzzle): int
    {
        usort($puzzle, function ($handBidA, $handBidB) {
            return $this->compareHandWithJokerRule($handBidA['hand'], $handBidB['hand']);
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

    public function compareHandWithJokerRule(string $handA, string $handB): int
    {
        $handAType = $this->getHandTypeWithJokerRule($handA);
        $handBType = $this->getHandTypeWithJokerRule($handB);
        if ($handAType === $handBType) {
            return $this->compareHandStrengthWithJokerRule($handA, $handB);
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

    public function getHandTypeWithJokerRule(string $hand): int
    {
        $counts = count_chars($hand);
        $jokerCount = $counts[ord('J')];
        $counts = array_filter($counts);

        if ($jokerCount === 5) {
            return self::FIVE_OF_A_KIND;
        } elseif ($jokerCount === 4) {
            return self::FIVE_OF_A_KIND;
        } elseif ($jokerCount === 3) {
            if (in_array(2, $counts)) {
                return self::FIVE_OF_A_KIND; // JJJAA
            }
            return self::FOUR_OF_A_KIND; // JJJAB
        } elseif ($jokerCount === 2) {
            if (in_array(3, $counts)) {
                return self::FIVE_OF_A_KIND; // JJAAA
            } elseif (count($counts) === 3) {
                return self::FOUR_OF_A_KIND; // JJAAB
            }
            return self::THREE_OF_A_KIND; // JJABC;
        } elseif ($jokerCount === 1) {
            if (in_array(4, $counts)) {
                return self::FIVE_OF_A_KIND; // JAAAA
            } elseif (in_array(3, $counts)) {
                return self::FOUR_OF_A_KIND; // JAAAB
            } elseif (in_array(2, $counts) && count($counts) === 3) {
                return self::FULL_HOUSE; // JAABB
            } elseif (in_array(2, $counts)) {
                return self::THREE_OF_A_KIND; // JAABC
            }
            return self::ONE_PAIR; // JABCD
        }
        return self::getHandType($hand);
    }

    public function compareHandStrengthWithJokerRule(string $handA, string $handB): int
    {
        for ($i = 0; $i < 5; $i++) {
            if ($handA[$i] === $handB[$i]) {
                continue;
            }
            if ($this->getCardStrengthWithJokerRule($handA[$i]) > $this->getCardStrengthWithJokerRule($handB[$i])) {
                return 1;
            }
            return -1;
        }
        return 0;
    }

    public function getCardStrengthWithJokerRule(string $card): int
    {
        return match ($card) {
            'A' => 14,
            'K' => 13,
            'Q' => 12,
            'J' => 1,
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
            "Part 2" => $this->solvePart2($puzzle),
        ];
    }
}
