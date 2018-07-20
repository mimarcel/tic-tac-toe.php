<?php
namespace Max\TicTacToe;

class Server implements \Ratchet\MessageComponentInterface {
    const MESSAGE_ACTION_NEW_NONE = 'none';
    const MESSAGE_ACTION_NEW_GAME = 'new';
    const MESSAGE_ACTION_CONNECT = 'connect';
    const MESSAGE_ACTION_MARK = 'mark';

    /** @var Server\Logger */
    protected $logger;
    /** @var Server\Game[] */
    protected $games;
    /** @var \SplObjectStorage */
    protected $clients;

    /**
     * @param \Max\TicTacToe\Server\Logger $logger
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
        $this->games = [];
        $this->clients = new \SplObjectStorage();
    }
    
    public function onOpen(\Ratchet\ConnectionInterface $connection)
    {
        $this->clients->attach($connection);

        $this->logger->log("Connection open for client {$connection->resourceId}.");
    }

    public function onMessage(\Ratchet\ConnectionInterface $from, $message)
    {
        $message = trim($message);
        $this->logger->log("Receive message `$message` from client {$from->resourceId}.");

        $message = json_decode($message, true);
        $action = $message['action'] ?? self::MESSAGE_ACTION_NEW_NONE;

        try {
            switch ($action) {
                case self::MESSAGE_ACTION_NEW_GAME:
                    $game = new \Max\TicTacToe\Server\Game($from->resourceId . '_' . uniqid());
                    $this->games[$game->getId()] = $game;
                    $game->connectPlayer(new \Max\TicTacToe\Server\Player($from, \Max\TicTacToe\Game\Grid::MARK_X));
                    break;
                case self::MESSAGE_ACTION_CONNECT:
                    $game = $this->_getGame($message);
                    $game->connectPlayer(new \Max\TicTacToe\Server\Player($from, \Max\TicTacToe\Game\Grid::MARK_0));
                    break;
                case self::MESSAGE_ACTION_MARK:
                    $game = $this->_getGame($message);
                    $this->_mark($from, $game, $message);
                    break;
                default:
                    throw new \Max\TicTacToe\Server\Exception('Unknown action.');
            }

            foreach ($game->getPlayers() as $player) {
                if (!$player) {
                    continue;
                }
                
                /** @var \Max\TicTacToe\Server\Player $player */
                $this->_sendMessage(
                    $player->getConnection(),
                    [
                        'game' => [
                            'id' => $game->getId(),
                            'status' => $game->getGameStatus(),
                            'grid' => $game->getCurrentGridView(),
                            'winner' => $game->getGameWinner(),
                        ],
                    ]
                );
            }
        } catch (\Max\TicTacToe\Server\Exception $exception) {
            $this->_sendMessage($from, ['message' => $exception->getMessage()]);
        } catch (\Max\TicTacToe\Exception $exception) {
            $this->_sendMessage($from, ['message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            $this->logger->log((string)$exception);
            $this->_sendMessage($from, ['message' => 'An unexpected exception has occurred.']);
        }
    }

    public function onClose(\Ratchet\ConnectionInterface $connection)
    {
        $this->clients->detach($connection);

        echo "Connection {$connection->resourceId} has disconnected\n";
    }

    public function onError(\Ratchet\ConnectionInterface $connection, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $connection->close();
    }

    /**
     * @param $message
     *
     * @return \Max\TicTacToe\Server\Game
     *
     * @throws Server\Exception
     */
    protected function _getGame($message)
    {
        $gameId = $message['id'] ?? null;
        if (isset($this->games[$gameId])) {
            return $this->games[$gameId];
        } else {
            throw new \Max\TicTacToe\Server\Exception("Unknown game with id `$gameId`.");
        }
    }

    /**
     * @param \Max\TicTacToe\Server\Game $game
     * @param $connection
     * @param $mark
     *
     * @return Server\Player|null
     */
    protected function _getPlayer($game, $connection, $mark = null)
    {
        foreach ($game->getPlayers() as $player) {
            if ($player->getConnection() === $connection) {
                if ($mark === null || $player->getMark() === $mark) {
                    return $player;
                }
            }
        }

        return null;
    }

    /**
     * @param \Ratchet\ConnectionInterface $from
     * @param \Max\TicTacToe\Server\Game $game
     * @param array $message
     *
     * @throws Server\Exception
     */
    protected function _mark($from, $game, $message)
    {
        $x = $message['x'] ?? null;
        $y = $message['y'] ?? null;
        if ($x === null || $y === null) {
            throw new \Max\TicTacToe\Server\Exception('Missing mark positions.');
        }

        $validPlayer = null;

        if (!$this->_getPlayer($game, $from)) {
            throw new \Max\TicTacToe\Server\Exception('You are not connected to this game.');
        }

        if (!$this->_getPlayer($game, $from, $game->getCurrentMark())) {
            throw new \Max\TicTacToe\Server\Exception('Please wait for your turn.');
        }

        $game->mark($x, $y);
    }

    /**
     * @param \Ratchet\ConnectionInterface $to
     * @param $message
     */
    protected function _sendMessage($to, $message)
    {
        $message = json_encode($message);

        $this->logger->log("Send message `$message` to client {$to->resourceId}.");
        $to->send($message . "\n");
    }
}
