<?php

namespace PF;

use Exception;

class BowlingGame
{
    /** @var int[] */
    private array $rolls = [];

    /**
     * @param int $count
     * @throws Exception
     */
    public function roll(int $count): void
    {
        if ($count > 10 || $count < 0 || !is_int($count)) {
            throw new Exception('Just how did you manage that?');
        }

        $this->rolls[] = $count;
    }

    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += $this->getStrikeScore($roll);
                $roll++;
                continue;
            }

            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }
            $score += $this->getNormalScore($roll);

            $roll += 2;
        }

        return $score;
    }

    /**
     * @param int $roll
     * @return int|mixed
     */
    public function getNormalScore(int $roll)
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isSpare(int $roll): bool
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1] === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getStrikeScore(int $roll): int
    {
        return $this->rolls[$roll + 1] + $this->rolls[$roll + 2] + 10;
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }
}