<?php
//helper functions
require_once 'core/functions.helper.php';
// database class
require_once 'core/class.pdo.php';
$Db = Database::instance();

// other classes
// game class
require_once 'classes/class.game.php';
$Game = new Game($Db);
// auth class
require_once 'classes/class.auth.php';
$Auth = new Auth($Db, $Game);
// controller class
require_once 'core/class.controller.php';
$Controller = new Controller ($Game, $Auth);