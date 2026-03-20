<?php
require_once 'inc/functions.php';

init();
handleRequest();

require_once 'templates/head.php';

// dump($_SESSION);
// dump($_POST);

if ($_SESSION['gameStarted'] === false) {
    require_once 'templates/startForm.php';
} else {
    if(!isset($_SESSION['gameWon'])) {
        require_once 'templates/gameForm.php';
    } else {
        require_once 'templates/gameResultForm.php';
    }
}

require_once 'templates/foot.php';