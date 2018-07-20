<?php

namespace Max\TicTacToeTest;

class GameManagerTest extends \PHPUnit\Framework\TestCase
{
    /* @var \Max\TicTacToe\GameManager */
    protected $gameManager;

    protected function setUp()
    {
        parent::setUp();

        $this->gameManager = new \Max\TicTacToe\GameManager();
    }

    public function testGamesCount()
    {
        $this->assertEquals($this->gameManager->getGamesCount(), 0);
    }
}
