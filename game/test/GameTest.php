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
        for ($i = 0; $i < $playersCount; $i++) {
            $this->game->connectPlayer(new Player());
        }

        $this->assertTrue($this->game->check() == $expectedGameStatusWait);
    }

    public function providerConnectPlayers()
    {
        return [
            [0, \Max\TicTacToe\Game::GAME_STATUS_WAIT],
            [1, \Max\TicTacToe\Game::GAME_STATUS_WAIT],
            [2, \Max\TicTacToe\Game::GAME_STATUS_IN_PROGRESS],
        ];
    }
}
