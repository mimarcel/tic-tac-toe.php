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
        $this->connectPlayers($playersCount);

        $this->assertTrue($this->game->check() == $expectedGameStatusWait);
    }

    public function testConnect3Players()
    {
        try {
            $this->connectPlayers(3);
        } catch (\Max\TicTacToe\Exception $exception) {
            $this->assertEquals('Unable to connect more than 2 players in the game.', $exception->getMessage());
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

    protected function connectPlayers($playersCount)
    {
        for ($i = 0; $i < $playersCount; $i++) {
            $this->game->connectPlayer(new Player());
        }
    }
}
