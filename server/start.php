<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__. '/../game/src/Game.php';
require __DIR__. '/../game/src/Game/Grid.php';
require __DIR__. '/../game/src/Player.php';
require __DIR__. '/../game/src/Exception.php';
require __DIR__. '/src/Server.php';
require __DIR__. '/src/Server/Exception.php';
require __DIR__. '/src/Server/Game.php';
require __DIR__. '/src/Server/Player.php';


$server = \Ratchet\Server\IoServer::factory(
    new \Max\TicTacToe\Server(),
    8080
);

$server->run();
