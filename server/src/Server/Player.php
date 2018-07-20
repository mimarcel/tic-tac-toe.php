<?php
namespace Max\TicTacToe\Server;

class Player extends \Max\TicTacToe\Player
{
    /** @var \Ratchet\ConnectionInterface */
    private $connection;
    protected $mark;

    public function __construct(
        \Ratchet\ConnectionInterface $connection,
        $mark
    ) {
        $this->connection = $connection;
        $this->mark = $mark;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getMark()
    {
        return $this->mark;
    }
}
