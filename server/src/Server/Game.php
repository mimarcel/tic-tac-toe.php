<?php
namespace Max\TicTacToe\Server;

/**
 * @method \Max\TicTacToe\Server\Player[] getPlayers
 */
class Game extends \Max\TicTacToe\Game
{
    protected $id;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
