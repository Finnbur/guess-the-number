<?php
if (isset($_POST['action']) && $_POST['action'] === 'start' && isset($_POST['gamemode'])) {
    $_SESSION['gamemode'] = $_POST['gamemode'];
}

$currentMode = $_SESSION['gamemode'] ?? 'basic';

// game class
switch ($currentMode) {
    case 'basic':
    default:
        require_once 'classes/class.basicGame.php';
        $Game = new BasicGame();
        break;

    case 'rush':
        require_once 'classes/class.rushGame.php';
        $Game = new RushGame();
        break;
}

//helper functions
require_once 'core/functions.helper.php';
// database class
require_once 'core/class.pdo.php';
$Db = Database::instance();
// auth class
require_once 'classes/class.auth.php';
$Auth = new Auth($Db, $Game);
// controller class
require_once 'core/class.controller.php';
$Controller = new Controller ($Game, $Auth);