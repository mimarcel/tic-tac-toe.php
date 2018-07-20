<?php

namespace Max\TicTacToeTest;

use Max\TicTacToe\Player;

class GameTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Max\TicTacToe\Game */
    protected $game;

    protected function setUp()
    {
        parent::setUp();

        $this->game= new \Max\TicTacToe\Game();
    }

    /**
     * @param $playersCount
     * @param $expectedGameStatusWait
     *
     * @dataProvider providerConnectPlayers
     */
    public function testConnectPlayers($playersCount, $expectedGameStatusWait)
    {
        $this->_connectPlayers($playersCount);

        $this->assertTrue($this->game->check() == $expectedGameStatusWait);
    }

    public function testConnect3Players()
    {
        try {
            $this->_connectPlayers(3);
        } catch (\Max\TicTacToe\Exception $exception) {
            $this->assertEquals('Unable to connect more than 2 players in the game.', $exception->getMessage());
            return;
        }

        $this->fail('Expected exception but nothing thrown.');

    }

    /**
     * @param $marks
     * @param $expectedGridView
     *
     * @dataProvider providerPlay
     */
    public function testPlay($marks, $expectedGridView)
    {
        $this->_connectPlayers(2);

        foreach ($marks as $mark) {
            $this->game->mark($marks[0], $mark[1]);
        }

        $this->assertEquals($expectedGridView, $this->game->getCurrentGridView());
    }

    public function testPlayWithNotEnoughPlayers()
    {
        for ($playersCount = 0; $playersCount < 2; $playersCount++) {
            $this->_connectPlayers($playersCount);

            try {
                $this->game->mark(0 ,0);
            } catch (\Max\TicTacToe\Exception $exception) {
                $this->assertEquals('Game is not in progress.', $exception->getMessage());
                continue;
            }

            $this->fail('Expected exception but nothing thrown.');
        }
    }

    public function providerConnectPlayers()
    {
        return [
            [0, \Max\TicTacToe\Game::GAME_STATUS_WAIT],
            [1, \Max\TicTacToe\Game::GAME_STATUS_WAIT],
            [2, \Max\TicTacToe\Game::GAME_STATUS_IN_PROGRESS],
        ];
    }

    public function providerPlay()
    {
        return [
            [[], "   \n   \n   \n"],
        ];
    }

    protected function _connectPlayers($playersCount)
    {
        for ($i = 0; $i < $playersCount; $i++) {
            $this->game->connectPlayer(new Player());
        }
    }
}
