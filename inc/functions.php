<?php
session_start();

function init() {
    if(!isset($_SESSION['gameStarted'])) {
        $_SESSION['gameStarted'] = false;
        $_SESSION['maxGuesses'] = 10;
        $_SESSION['guesses'] = [];
        $_SESSION['secretNumber'] = null;
        $_SESSION['timePerGuess'] = 15;
        $_SESSION['min'] = 1;
        $_SESSION['max'] = 100;
        $_SESSION['loggedIn'] = false;
    }
    
    handleRequest();
}

function handleRequest() {
    if($_SERVER['REQUEST_METHOD'] === "POST") {
        if($_POST['action']) {
            switch($_POST['action']) {
                case 'start':
                    handleStart();
                    break;
                case 'guess':
                    handleGuess();
                    break;
                case 'again':
                    handleAgain();
                    break;
                case 'reset':
                    handleReset();
                    break;
                case 'login':
                    handleLogin();
                    break;
                case 'register':
                    handleRegister();
                    break;
                case 'logout':
                    handleLogout();
                    break;
            }
        }
    }
}

function handleStart() {
    $min = $_POST['min'];
    $max = $_POST['max'];
    $maxGuesses = $_POST['maxGuesses'];
    $timePerGuess = $_POST['timePerGuess'];
    $_SESSION['time'] = time();
    
    if($min >= $max) {
        return;
    }

    $_SESSION['min'] = $min;
    $_SESSION['max'] = $max;
    $_SESSION['maxGuesses'] = $maxGuesses;
    $_SESSION['timePerGuess'] = $timePerGuess;
    $_SESSION['secretNumber'] = mt_rand($min, $max);
    $_SESSION['guesses'] = [];
    $_SESSION['gameStarted'] = true;

    reload();
}

function handleGuess() {
    $guess = $_POST['guess'];
    $secret = $_SESSION['secretNumber'];
    $_SESSION['time'] = time();

    if($guess < $secret) {
        respond("Your guess is TOO LOW", "primary");
        addGuess($guess, "TOO LOW", "primary");
    } elseif($guess > $secret) {
        respond("Your guess is TOO HIGH", "warning");
        addGuess($guess, "TOO HIGH", "warning");
    } else {
        $_SESSION['gameWon'] = true;
        addGuess($guess, "WIN", "success");
    }

    if(count($_SESSION['guesses']) >= $_SESSION['maxGuesses']) {
        $_SESSION['gameWon'] = false;
    }

    reload();
}

function handleAgain() {
    resetGame();

    //Reset variables
    $_SESSION['guesses'] = [];
    $_SESSION['secretNumber'] = mt_rand($_SESSION['min'], $_SESSION['max']);
    
    reload();
}

function handleReset() {
    $_SESSION['gameStarted'] = false;
    resetGame();
    
    reload();
}

function handleLogin() {

}

function handleRegister() {

}

function handleLogout() {
    $_SESSION['loggedIn'] = false;
    unset($_SESSION['userId']);

    reload();
}

function resetGame() {
    unset($_SESSION['secretNumber']);
    unset($_SESSION['guesses']);
    unset($_SESSION['response']);
    unset($_SESSION['gameWon']);
}

function reload($location = null, $statusCode = 302, $exitAfter = true) {
    if($location === null) {
        $location = $_SERVER['PHP_SELF'];
    }

    if(strpos($location, '?') === 0) {
        $location = $_SERVER['PHP_SELF'] . $location;
    }

    header("Location: $location", true, $statusCode);

    if($exitAfter) {
        exit();
    }
}

function respond($message, $type = 'info') {
    $_SESSION['response'] = ['message' => $message, 'type' => $type];
}

function addGuess($guess, $message, $type) {
    $_SESSION['guesses'][] = ['guess' => $guess, 'message' => $message, 'type' => $type];
}

function dump($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}