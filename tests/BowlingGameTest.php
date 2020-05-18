<?php

use PF\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    public function testGetScore_withZeroes_scoreWillBeZero()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        $score = $game->getScore();

        self::assertEquals(0, $score);
    }

    public function testGetScore_withOnes_scoreWillBe20()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(20, $score);
    }

    public function testGetScore_withASpare_willAddSpareBonus()
    {
        $game = new BowlingGame();

        $game->roll(8);
        $game->roll(2);
        $game->roll(5);

        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(37, $score);
    }

    public function testGetScore_withAStrike_willAddStrikeBonus()
    {
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(5);
        $game->roll(3);

        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(42, $score);
    }

    public function testGetScore_withPerfectGame_willReturn300()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 12; $i++) {
            $game->roll(10);
        }

        self::assertEquals(300, $game->getScore());
    }

    public function testGetScore_withUnfinishedGame_withSpareBonus_willReturn20()
    {
        $game = new BowlingGame();

        $game->roll(3);
        $game->roll(7);
        $game->roll(5);

        self::assertEquals(20, $game->getScore());
    }

    public function testGetScore_withUnfinishedGame_withStrikeBonus_willReturn60()
    {
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(10);
        $game->roll(10);

        self::assertEquals(60, $game->getScore());
    }

    public function testRoll_withElevenPoints_willThrowException()
    {
        $game = new BowlingGame();

        self::expectException(\Exception::class);

        $game->roll(11);
    }

    public function testGetScore_withExtraThrows_willReturn20()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 30; $i++) {
            $game->roll(1);
        }

        self::assertEquals(20, $game->getScore());
    }
}