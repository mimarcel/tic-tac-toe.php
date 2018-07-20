<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__. '/../game/src/Game.php';
require __DIR__. '/../game/src/Game/Grid.php';
require __DIR__. '/../game/src/Player.php';
require __DIR__. '/../game/src/Exception.php';
require __DIR__. '/src/Server.php';
require __DIR__. '/src/Server/Exception.php';
require __DIR__. '/src/Server/Game.php';
require __DIR__. '/src/Server/Logger.php';
require __DIR__. '/src/Server/Player.php';


$logger = new \Max\TicTacToe\Server\Logger();
$server = \Ratchet\Server\IoServer::factory(
    new \Max\TicTacToe\Server($logger),
    8080
);

$logger->log('Server started');
$logger->log('Waiting for clients...');
$server->run();
