<?php
define('TESTS_BASE', __DIR__);

function requireFile($path) {
    require_once TESTS_BASE . DIRECTORY_SEPARATOR . "../" . $path;
}

requireFile('src/Game.php');
requireFile('src/Game/Grid.php');
requireFile('src/Player.php');
requireFile('src/Exception.php');
