<?php
define('TESTS_BASE', __DIR__);

function requireFile($path) {
    require_once TESTS_BASE . DIRECTORY_SEPARATOR . "../" . $path;
}

requireFile('src/GameManager.php');
