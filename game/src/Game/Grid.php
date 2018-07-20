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

    public function checkTie()
    {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->getMark($i, $j) === \Max\TicTacToe\Game\Grid::MARK_EMPTY) {
                    return false;
                }
            }
        }

        return true;
    }

    public function checkWinner()
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
            $mark = $this->getMark($winRow[0][0], $winRow[0][1]);
            if ($mark !== self::MARK_EMPTY
                && $mark == $this->getMark($winRow[1][0], $winRow[1][1])
                && $mark == $this->getMark($winRow[2][0], $winRow[2][1])) {
                return $mark;
            }
        }

        return null;
    }

    public function setMark($x, $y, $mark)
    {
        $this->_checkPositions($x, $y);

        if ($this->getMark($x, $y) !== \Max\TicTacToe\Game\Grid::MARK_EMPTY) {
            throw new \Max\TicTacToe\Exception('Position is already marked.');
        }

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
