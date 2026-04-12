<?php

include_once 'class.game.php';

class RushGame extends Game {
    public function initializeDefaults() {
        $_SESSION['gameTime'] = 60;
        $_SESSION['correctCount'] = 0;
        $_SESSION['rushGame'] = true;
    }

    public function handleGuess() {
        $guess  = $_POST['guess'];
        $secret = $_SESSION['secretNumber'];

        if(count($_SESSION['guesses']) >= ($_SESSION['maxGuesses'] - 1)) {
            $this->gameEnd(true);
        }

        // Process the guess
        if ($guess < $secret) {
            respond("Your guess is TOO LOW", "primary", "game");
            $this->addGuess($guess, "TOO LOW", "primary");
        } elseif ($guess > $secret) {
            respond("Your guess is TOO HIGH", "warning", "game");
            $this->addGuess($guess, "TOO HIGH", "warning");
        } else {
            // CORRECT → new number, game continues
            $this->addGuess($guess, "WIN", "success");
            $_SESSION['correctCount'] = $_SESSION['correctCount'] + 1;
            $_SESSION['secretNumber'] = $this->generateSecretNumber();

            respond("Correct! New number generated.", "success", "game");
        }

        // reload();
    }

    public function timerGameWin() {
        return true;
    }

    public function calculateScore($gameWon, $timeTaken, $guessesUsed, $maxGuesses) {
        $correctCount = $_SESSION['correctCount'] ?? 0;

        // Requirement: Must have at least one correct guess to get points
        if ($correctCount <= 0) {
            return 0;
        }

        // Points per success
        $baseScore = $correctCount * 500;

        // 2. Range Multiplier
        $range = $_SESSION['max'] - $_SESSION['min'];
        $rangeMultiplier = 1 + ($range / 1000);

        // 3. Difficulty Multiplier
        $difficultyMultiplier = 10 / max(1, $maxGuesses);

        // Final Calculation
        $score = $baseScore * $rangeMultiplier * $difficultyMultiplier;

        return max(0, round($score));
    }
}