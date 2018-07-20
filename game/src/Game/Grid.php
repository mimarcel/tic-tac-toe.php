<?php
namespace Max\TicTacToe\Game;

class Grid
{
    const MARK_X = 'X';
    const MARK_0 = '0';
    const MARK_EMPTY = ' ';

    protected $matrix = [
        [self::MARK_EMPTY, self::MARK_EMPTY, self::MARK_EMPTY],
        [self::MARK_EMPTY, self::MARK_EMPTY, self::MARK_EMPTY],
        [self::MARK_EMPTY, self::MARK_EMPTY, self::MARK_EMPTY],
    ];

    public function __toString()
    {
        $s = '';
        foreach ($this->matrix as $row) {
            foreach ($row as $mark) {
                $s .= $mark;
            }
        }

        return $s;
    }

    public function setMark($x, $y, $mark)
    {
        $this->_checkPositions($x, $y);

        $this->matrix[$x][$y] = $mark;
    }

    public function getMark($x, $y)
    {
        $this->_checkPositions($x, $y);

        return $this->matrix[$x][$y];
    }

    private function _checkPositions($x, $y)
    {
        if ($x < 0 || $x > 2) {
            throw new \Max\TicTacToe\Exception('Invalid position.');
        }
        if ($y < 0 || $y > 2) {
            throw new \Max\TicTacToe\Exception('Invalid position.');
        }
    }
}
