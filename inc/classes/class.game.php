<?php

class Game {
    private $db;

    public $gameStarted = false;
    public $maxGuesses = 10;
    public $guesses = [];
    public $secretNumber = null;
    public $timePerGuess = 15;
    public $min = 1;
    public $max = 100;
    public $loggedIn = false;

    public function __construct($db) {
        $this->db = $db;

        if(!isset($_SESSION['gameStarted'])) {
            $_SESSION['gameStarted'] = $this->gameStarted;
            $_SESSION['maxGuesses'] = $this->maxGuesses;
            $_SESSION['guesses'] = $this->guesses;
            $_SESSION['secretNumber'] = $this->secretNumber;
            $_SESSION['timePerGuess'] = $this->timePerGuess;
            $_SESSION['min'] = $this->min;
            $_SESSION['max'] = $this->max;
            $_SESSION['loggedIn'] = $this->loggedIn;
        }
    }

    public function handleStart() {
        $min = $_POST['min'];
        $max = $_POST['max'];
        $maxGuesses = $_POST['maxGuesses'];
        $timePerGuess = $_POST['timePerGuess'];

        if ($min >= $max) {
            return;
        }

        $_SESSION['startTime'] = time();
        $_SESSION['time'] = time();

        $_SESSION['min'] = $min;
        $_SESSION['max'] = $max;
        $_SESSION['maxGuesses'] = $maxGuesses;
        $_SESSION['timePerGuess'] = $timePerGuess;
        $_SESSION['secretNumber'] = mt_rand($min, $max);
        $_SESSION['guesses'] = [];
        $_SESSION['gameStarted'] = true;

        reload();
    }

    public function handleGuess() {
        $guess = $_POST['guess'];
        $secret = $_SESSION['secretNumber'];
        $_SESSION['time'] = time();

        if($guess < $secret) {
            respond("Your guess is TOO LOW", "primary", "game");
            $this->addGuess($guess, "TOO LOW", "primary");
        } elseif($guess > $secret) {
            respond("Your guess is TOO HIGH", "warning", "game");
            $this->addGuess($guess, "TOO HIGH", "warning");
        } else {
            $this->addGuess($guess, "WIN", "success");
            $this->gameEnd(true);
        }

        if(count($_SESSION['guesses']) >= $_SESSION['maxGuesses']) {
            $this->gameEnd(false);
        }

        reload();
    }

    public function handleAgain() {
        $this->resetGame();

        //Reset variables
        $_SESSION['time'] = time();
        $_SESSION['startTime'] = time();
        $_SESSION['guesses'] = [];
        $_SESSION['secretNumber'] = mt_rand($_SESSION['min'], $_SESSION['max']);
        
        reload();
    }

    function handleReset() {
        $_SESSION['gameStarted'] = false;
        $this->resetGame();
        
        reload();
    }
    public function resetGame() {
        unset($_SESSION['secretNumber']);
        unset($_SESSION['guesses']);
        unset($_SESSION['response']);
        unset($_SESSION['gameWon']);
        unset($_SESSION['time']);
        unset($_SESSION['startTime']);
        unset($_SESSION['endTime']);
    }
    public function addGuess($guess, $message, $type) {
        $_SESSION['guesses'][] = ['guess' => $guess, 'message' => $message, 'type' => $type];
    }

    public function gameEnd($gameWon) {
        $_SESSION['gameWon'] = $gameWon;
        $_SESSION['endTime'] = time();
    }
}