<?php

class Game {
    private $db;

    public function __construct($db) {
        $this->db = $db;

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
    }

    public function handleStart() {
        $min = $_POST['min'];
        $max = $_POST['max'];
        $maxGuesses = $_POST['maxGuesses'];
        $timePerGuess = $_POST['timePerGuess'];

        if ($min < 1) reload();
        if ($timePerGuess < 1) reload();
        if ($maxGuesses < 1) reload();
        if ($min >= $max) reload();

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

        if(count($_SESSION['guesses']) >= ($_SESSION['maxGuesses'] - 1)) {
            $this->gameEnd(false);
        }

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
        unset($_SESSION['score']);
        unset($_SESSION['saveScore']);
    }
    public function addGuess($guess, $message, $type) {
        $_SESSION['guesses'][] = ['guess' => $guess, 'message' => $message, 'type' => $type];
    }

    public function gameEnd($gameWon) {
        unset($_SESSION['time']);
        $_SESSION['gameWon'] = $gameWon;
        $_SESSION['endTime'] = time();

        $timeTaken = $_SESSION['endTime'] - $_SESSION['startTime'];

        $score = $this->calculateScore($gameWon, $timeTaken, count($_SESSION['guesses']), $_SESSION['maxGuesses']);

        $_SESSION['score'] = $score;
        
        if($_SESSION['loggedIn']) {
            $this->saveScore($timeTaken);
        }
    }

    public function saveScore($timeTaken) {
        $this->db->run("INSERT INTO scores (time, guesses, maxGuesses, gameWon, minNumber, maxNumber, added, userId, score) VALUES (:time, :guesses, :maxGuesses, :gameWon, :minNumber, :maxNumber, :added, :userId, :score)", [
                ':time' => $timeTaken,
                ':guesses' => count($_SESSION['guesses']),
                ':maxGuesses' => $_SESSION['maxGuesses'],
                ':gameWon' => $_SESSION['gameWon'] ? 1 : 0,
                ':minNumber' => $_SESSION['min'],
                ':maxNumber' => $_SESSION['max'],
                ':score' => $_SESSION['score'],
                ':added' => date('Y-m-d H:i:s'),
                ':userId' => $_SESSION['userId']
            ]);
    }

    public function checkTimer() {
        if (isset($_SESSION['time'], $_SESSION['timePerGuess'])) {
            if ((time() - $_SESSION['time']) >= $_SESSION['timePerGuess']) {
                $this->gameEnd(false);
                reload();
            }
        }
    }

    public function calculateScore($gameWon, $time, $guessesUsed, $maxGuesses) {
        if (!$gameWon) {
            return 0;
        }

        // Correct range calculation
        $range = $_SESSION['max'] - $_SESSION['min'];

        // Normalize factors (0 → bad, 1 → good)
        $guessEfficiency = ($maxGuesses - $guessesUsed + 1) / $maxGuesses;

        // Bigger range = better (log to prevent huge numbers breaking score)
        $rangeScore = log($range + 1);

        // Fewer max guesses = harder → reward
        $difficultyScore = 1 / $maxGuesses;

        // Time penalty (smooth decay instead of harsh subtraction)
        $timeScore = 1 / (1 + $time / 30); // adjust 30 to tune time importance

        // Final weighted score
        $score = (
            ($guessEfficiency * 0.4) +
            ($rangeScore * 0.2) +
            ($difficultyScore * 0.2) +
            ($timeScore * 0.2)
        ) * 1000;

        return max(0, round($score));
    }
}