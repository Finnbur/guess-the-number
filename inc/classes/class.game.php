<?php
require_once __DIR__ . '/../core/class.pdo.php';
abstract class Game {
    protected $db;

    public function __construct() {
        $this->db = Database::instance();

        if(!isset($_SESSION['gameStarted'])) {
            $_SESSION['gameStarted'] = false;
            $_SESSION['maxGuesses'] = 10;
            $_SESSION['min'] = 1;
            $_SESSION['max'] = 100;
            $_SESSION['guesses'] = [];
            $_SESSION['secretNumber'] = null;
            $_SESSION['loggedIn'] = false;
            $_SESSION['basicGame'] = false;
            $_SESSION['rushGame'] = false;
            $_SESSION['gamemode'] = 'basic';
            $_SESSION['difficulty'] = 'custom';

            $this->initializeDefaults();
        }
    }

    abstract protected function initializeDefaults();

    public function handleStart() {
        $maxGuesses = $_POST['maxGuesses'];
        $gameTime = $_POST['gameTime'];
        $difficulty = $_POST['difficulty'];

        switch($difficulty) {
            case 'custom':
                $min = $_POST['min'];
                $max = $_POST['max'];
                break;
            case 'easy':
                $min = 1;
                $max = 10;
                break;
            case 'normal':
                $min = 1;
                $max = 50;
                break;
            case 'hard':
                $min = 1;
                $max = 100;
                break;
        }

        if ($gameTime < 1) reload();
        if ($min < 1) reload();
        if ($maxGuesses < 1) reload();
        if ($min >= $max) reload();

        $_SESSION['difficulty'] = $difficulty;
        $_SESSION['min'] = $min;
        $_SESSION['max'] = $max;
        $_SESSION['gameTime'] = $gameTime;
        $_SESSION['maxGuesses'] = $maxGuesses;

        $_SESSION['startTime'] = time();
        $_SESSION['time'] = time();
        $_SESSION['secretNumber'] = $this->generateSecretNumber();
        $_SESSION['guesses'] = [];
        $_SESSION['gameStarted'] = true;
        $_SESSION['correctCount'] = 0;

        reload();
    }

    protected function generateSecretNumber() {
        return mt_rand($_SESSION['min'], $_SESSION['max']);
    }

    abstract protected function handleGuess();

    public function handleAgain() {
        $this->resetGame();

        $_SESSION['startTime'] = time();
        $_SESSION['time'] = time();
        $_SESSION['secretNumber'] = $this->generateSecretNumber();
        $_SESSION['guesses'] = [];
        $_SESSION['correctCount'] = 0;

        reload();
    }

    public function handleReset() {
        $_SESSION['gameStarted'] = false;
        $this->resetGame();

        reload();
    }

    public function resetGame(){
        unset($_SESSION['secretNumber']);
        unset($_SESSION['guesses']);
        unset($_SESSION['response']);
        unset($_SESSION['gameWon']);
        unset($_SESSION['time']);
        unset($_SESSION['startTime']);
        unset($_SESSION['endTime']);
        unset($_SESSION['score']);
        unset($_SESSION['saveScore']);
        unset($_SESSION['totalTime']);
        unset($_SESSION['correctCount']);
        unset($_SESSION['basicGame']);
        unset($_SESSION['rushGame']);
    }

    public function addGuess($guess, $message, $type){
        $_SESSION['guesses'][] = ['guess' => $guess, 'message' => $message, 'type' => $type];
    }

    public function gameEnd($gameWon) {
        unset($_SESSION['time']);
        $_SESSION['gameWon'] = $gameWon;
        $_SESSION['endTime'] = time();

        $timeTaken   = $_SESSION['endTime'] - $_SESSION['startTime'];
        $guessesUsed = count($_SESSION['guesses']);

        $score = $this->calculateScore($gameWon, $timeTaken, $guessesUsed, $_SESSION['maxGuesses']);
        $_SESSION['score'] = $score;

        if ($_SESSION['loggedIn'] ?? false) {
            $this->saveScore($timeTaken);
        }
    }

    public function saveScore($timeTaken) {
        $this->db->run("INSERT INTO scores (time, guesses, maxGuesses, gameWon, minNumber, maxNumber, gamemode, added, userId, score) VALUES (:time, :guesses, :maxGuesses, :gameWon, :minNumber, :maxNumber, :gamemode, :added, :userId, :score)", [
                ':time' => $timeTaken,
                ':guesses' => count($_SESSION['guesses']),
                ':maxGuesses' => $_SESSION['maxGuesses'],
                ':gameWon' => $_SESSION['gameWon'] ? 1 : 0,
                ':minNumber' => $_SESSION['min'],
                ':maxNumber' => $_SESSION['max'],
                ':score' => $_SESSION['score'],
                ':gamemode' => $_SESSION['gamemode'],
                ':added' => date('Y-m-d H:i:s'),
                ':userId' => $_SESSION['userId']
            ]);
    }

    abstract protected function calculateScore($gameWon, $timeTaken, $guessesUsed, $maxGuesses);

    abstract public function timerGameWin();

    public function checkTimer() {
        if (isset($_SESSION['time'], $_SESSION['gameTime'])) {
            if ((time() - $_SESSION['time']) >= $_SESSION['gameTime']) {
                $this->gameEnd($this->timerGameWin());
                reload();
            }
        }
    }
}