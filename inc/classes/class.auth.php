<?php

class Auth {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function handleLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == 'admin' && $password == 'admin') {
            $_SESSION['loggedIn'] = true;
            $_SESSION['userId'] = 1;
            reload();
        }
    }

    public function handleRegister() {

    }

    public function handleLogout() {
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['userId']);

        reload();
    }
}