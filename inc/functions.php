<?php
session_start();

function init() {
    if(!isset($_SESSION['gameStarted'])) {
        $_SESSION['gameStarted'] = false;
        $_SESSION['guesses'] = [];
        $_SESSION['secretNumber'] = null;
        $_SESSION['min'] = 1;
        $_SESSION['max'] = 100;
    }
}

function handleRequest() {
    if($_SERVER['REQUEST_METHOD'] === "POST") {
        switch($_POST['action']) {
            case 'start':
                handleStart();
                break;
            case 'guess':
                handleGuess();
                break;
            case 'reset':
                handleReset();
                break;
        }
    }
}

function handleStart() {
    $min = $_POST['min'];
    $max = $_POST['max'];
    
    if($min >= $max) {
        return;
    }

    $_SESSION['min'] = $min;
    $_SESSION['max'] = $max;
    $_SESSION['secretNumber'] = mt_rand($min, $max);
    $_SESSION['guesses'] = [];
    $_SESSION['gameStarted'] = true;

    reload();
}

function handleGuess() {
    $guess = $_POST['guess'];
    $secret = $_SESSION['secretNumber'];

    $_SESSION['guesses'][] = $guess;

    if($guess < $secret) {
        $_SESSION['message'] = "Your guess is TOO LOW!";
    } elseif($guess > $secret) {
        $_SESSION['message'] = "Your guess is TOO HIGH!";
    } else {
        $_SESSION['message'] = "CORRECT! The secret number was " . $secret . "!";
        $_SESSION['gameStarted'] = false;
    }

    reload();
}

function handleReset() {
    $_SESSION['gameStarted'] = false;
    unset($_SESSION['secretNumber']);
    unset($_SESSION['guesses']);
    unset($_SESSION['message']);
    
    reload();
}

function reload($location = null, $statusCode = 302, $exitAfter = true) {
    if($location === null) {
        $location = $_SERVER['PHP_SELF'];
    }

    if(strpos($location, '?') === 0) {
        $location = $_SERVER['PHP_SELF'] . $location;
    }

    header(printf('Location: %s,', $location), true, $statusCode);

    if($exitAfter) {
        exit();
    }
}

function dump($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}