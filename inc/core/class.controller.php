<?php

class Controller {
    private $game;
    private $auth;
    public function __construct($game, $auth) {
        $this->game = $game;
        $this->auth = $auth;

        $this->handleRequest();
    }

    public function router() {
        $page = $_GET['page'] ?? 'game';

        switch ($page) {
            case 'leaderboard':
                $this->leaderboard();
                break;

            case 'profile':
                $this->profile();
                break;

            case 'game':
            default:
                $this->game();
                break;
        }
    }

    private function leaderboard() {
        require_once 'templates/leaderboard.php';
    }

    private function profile() {
        require_once 'templates/profile.php';
    }

    private function game() {
        if ($_SESSION['gameStarted'] === false) {
            require_once 'templates/startForm.php';
        } else {
            if(!isset($_SESSION['gameWon'])) {
                $this->game->checkTimer();
                require_once 'templates/gameForm.php';
            } else {
                require_once 'templates/gameResultForm.php';
            }
        }
    }

    public function handleRequest() {
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            if($_POST['action']) {
                switch($_POST['action']) {
                    case 'start':
                        $this->game->handleStart();
                        break;
                    case 'guess':
                        $this->game->handleGuess();
                        break;
                    case 'again':
                        $this->game->handleAgain();
                        break;
                    case 'reset':
                        $this->game->handleReset();
                        break;
                    case 'login':
                        $this->auth->handleLogin();
                        break;
                    case 'register':
                        $this->auth->handleRegister();
                        break;
                    case 'logout':
                        $this->auth->handleLogout();
                        break;
                    case 'saveScore':
                        $this->auth->handleSaveScore();
                        break;
                }
            }
        }
    }
}