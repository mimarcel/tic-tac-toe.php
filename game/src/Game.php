<?php
namespace Max\TicTacToe;

class Game
{
    const GAME_STATUS_WAIT = 'wait';
    const GAME_STATUS_IN_PROGRESS = 'in progress';
    const GAME_STATUS_OVER = 'game over';

    protected $gameStatus = self::GAME_STATUS_WAIT;
    protected $gameWinner = \Max\TicTacToe\Game\Grid::MARK_EMPTY;
    protected $player1 = null;
    protected $player2 = null;
    protected $grid;
    protected $currentMark = \Max\TicTacToe\Game\Grid::MARK_X;

    public function __construct()
    {
        $this->grid = new \Max\TicTacToe\Game\Grid();
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

    public function mark($x, $y)
    {
        if ($this->gameStatus !== self::GAME_STATUS_IN_PROGRESS) {
            throw new \Max\TicTacToe\Exception('Game is not in progress.');
        }
        if ($this->grid->getMark($x, $y) !== \Max\TicTacToe\Game\Grid::MARK_EMPTY) {
            throw new \Max\TicTacToe\Exception('Position is already marked.');
        }

        $this->grid->setMark($x, $y, $this->currentMark);

        $this->_checkGameOver();
        $this->_changeCurrentMark();

        return $this->getGameStatus();
    }

    public function getCurrentGridView()
    {
        return $this->grid->__toString();
    }

    public function getCurrentMark()
    {
        return $this->currentMark;
    }

    public function getGameStatus()
    {
        return $this->gameStatus;
    }

    public function getGameWinner()
    {
        return $this->gameWinner;
    }

    public function getPlayers()
    {
        return [$this->player1, $this->player2];
    }

    protected function _checkGameOver()
    {
        $this->_checkGameOverWin();
        if ($this->getGameStatus() !== \Max\TicTacToe\Game::GAME_STATUS_OVER) {
            $this->_checkGameOverTie();
        }
    }

    protected function _checkGameOverWin()
    {
        $winRows = [
            [[0, 0], [1, 1], [2, 2]],
            [[0, 2], [1, 1], [2, 0]],
        ];
        for ($i = 0; $i < 3; $i++) {
            $winRows[] = [[$i, 0], [$i, 1], [$i, 2]];
            $winRows[] = [[0, $i], [1, $i], [2, $i]];
        }

        foreach ($winRows as $winRow) {
            $mark = $this->grid->getMark($winRow[0][0], $winRow[0][1]);
            if ($mark !== \Max\TicTacToe\Game\Grid::MARK_EMPTY
                && $mark == $this->grid->getMark($winRow[1][0], $winRow[1][1])
                && $mark == $this->grid->getMark($winRow[2][0], $winRow[2][1])) {
                $this->gameStatus = self::GAME_STATUS_OVER;
                $this->gameWinner = $mark;
                break;
            }
        }
    }

    protected function _checkGameOverTie()
    {
        $tie = true;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->grid->getMark($i, $j) === \Max\TicTacToe\Game\Grid::MARK_EMPTY) {
                    $tie = false;
                    break 2;
                }
            }
        }
        if ($tie) {
            $this->gameStatus = self::GAME_STATUS_OVER;
        }
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
