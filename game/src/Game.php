<?php
namespace Max\TicTacToe;

class Game
{
    const GAME_STATUS_WAIT = 0;
    const GAME_STATUS_IN_PROGRESS = 1;
    const GAME_STATUS_OVER = 2;

    protected $gameStatus = self::GAME_STATUS_WAIT;
    protected $player1 = null;
    protected $player2 = null;
    protected $grid;
    protected $currentMark = \Max\TicTacToe\Game\Grid::MARK_X;

    public function __construct()
    {
        $this->grid = new \Max\TicTacToe\Game\Grid();
    }

    public function check()
    {
        return $this->gameStatus;
    }

    public function connectPlayer($player)
    {
        if ($this->player1 === null) {
            $this->player1 = $player;
        } elseif ($this->player2 === null) {
            $this->player2 = $player;
            $this->gameStatus = self::GAME_STATUS_IN_PROGRESS;
        } else {
            throw new \Max\TicTacToe\Exception('Unable to connect more than 2 players in the game.');
        }
    }

    public function getCurrentGridView()
    {
        return $this->grid->__toString();
    }

    public function mark($x, $y)
    {
        if ($this->gameStatus !== self::GAME_STATUS_IN_PROGRESS) {
            throw new \Max\TicTacToe\Exception('Game is not in progress.');
        }
        if ($this->grid->getMark($x, $y) !== \Max\TicTacToe\Game\Grid::MARK_EMPTY) {
            throw new \Max\TicTacToe\Exception('Position is already marked.');
        }

        $this->grid->setMark($x, $y, $this->currentMark);

        $this->_changeCurrentMark();
    }

    protected function _changeCurrentMark()
    {
        if ($this->currentMark === \Max\TicTacToe\Game\Grid::MARK_X) {
            $this->currentMark = \Max\TicTacToe\Game\Grid::MARK_0;
        } else {
            $this->currentMark = \Max\TicTacToe\Game\Grid::MARK_X;
        }
    }
}
