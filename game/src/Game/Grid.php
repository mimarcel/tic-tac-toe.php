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

            $s .= "\n";
        }

        return $s;
    }
}
