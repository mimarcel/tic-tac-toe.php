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

        $this->assertEquals($expectedGameStatusWait, $this->game->getGameStatus());
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
     * @param $expectedGameStatusWait
     *
     * @dataProvider providerPlay
     */
    public function testPlay($marks, $expectedGridView, $expectedGameStatusWait)
    {
        $this->_connectPlayers(2);

        foreach ($marks as $mark) {
            $this->game->mark($mark[0], $mark[1]);
        }

        $this->assertEquals($expectedGridView, $this->game->getCurrentGridView());
        $this->assertEquals($expectedGameStatusWait, $this->game->getGameStatus());
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

    public function testPlayMarkTheSamePosition()
    {
        $this->_connectPlayers(2);

        try {
            $this->game->mark(0 ,0);
            $this->game->mark(0 ,0);
        } catch (\Max\TicTacToe\Exception $exception) {
            $this->assertEquals('Position is already marked.', $exception->getMessage());
            return;
        }

        $this->fail('Expected exception but nothing thrown.');
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
            [[], "         ", \Max\TicTacToe\Game::GAME_STATUS_IN_PROGRESS],
            [[[0, 0]], "X        ", \Max\TicTacToe\Game::GAME_STATUS_IN_PROGRESS],
            [[[0, 0], [0, 1]], "X0       ", \Max\TicTacToe\Game::GAME_STATUS_IN_PROGRESS],
            [[[0, 0], [0, 1], [0, 2]], "X0X      ", \Max\TicTacToe\Game::GAME_STATUS_IN_PROGRESS],
            [[[0, 0], [1, 0], [0, 1], [1, 1]], "XX 00    ", \Max\TicTacToe\Game::GAME_STATUS_IN_PROGRESS],
            [[[0, 0], [1, 0], [0, 1], [1, 1], [0, 2]], "XXX00    ", \Max\TicTacToe\Game::GAME_STATUS_OVER],
        ];
    }

    protected function _connectPlayers($playersCount)
    {
        for ($i = 0; $i < $playersCount; $i++) {
            $this->game->connectPlayer(new Player());
        }
    }
}
