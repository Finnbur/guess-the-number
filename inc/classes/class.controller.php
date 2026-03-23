<?php

class Controller {
    private $game;
    private $auth;
    public function __construct($game, $auth) {
        $this->game = $game;
        $this->auth = $auth;

        $this->handleRequest();
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
                }
            }
        }
    }
}