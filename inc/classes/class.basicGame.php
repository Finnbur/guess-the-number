<?php

include_once 'class.game.php';

class BasicGame extends Game {
    public function initializeDefaults() {
        $_SESSION['gameTime'] = 15;
        $_SESSION['basicGame'] = true;
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

    public function timerGameWin() {
        return false;
    }

    public function calculateScore($gameWon, $timeTaken, $guessesUsed, $maxGuesses) {
        if (!$gameWon) {
            return 0;
        }

        $range = $_SESSION['max'] - $_SESSION['min'];

        $guessEfficiency = ($maxGuesses - $guessesUsed + 1) / $maxGuesses;

        // Bigger range = better
        $rangeScore = log($range + 1);

        // Fewer max guesses = better
        $difficultyScore = 1 / $maxGuesses;

        // Time penalty
        $timeScore = 1 / (1 + $timeTaken / 30);

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