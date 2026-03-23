<?php

class Auth {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function handleLogin() {
        $username = $this->validate($_POST['username']);
        $password = $this->validate($_POST['password']);

        if (empty($username) || empty($password)) {
            respond("Forgot name or password", "danger", "login");
            reload();
        }

        // Run query
        $stmt = $this->db->run("SELECT id, username, password FROM users WHERE username = :username", [':username' => $username]);

        // Fetch result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($password, $row['password'])) {
                $this->loginUser($row['id']);

                reload();
            }
        }

        // If we get here, login failed
        respond("Wrong name or password", "danger", "login");
        reload();
    }

    public function handleRegister() {
        $db = Database::instance();

        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // Basic validation
        if (empty($username) || empty($password) || empty($cpassword)) {
            respond("Forgot name or password", "danger", "register");
            reload();
        }

        // Check if username exists
        $stmt = $db->run("SELECT username FROM users WHERE username = :username", [':username' => $username]);

        if ($stmt->rowCount() > 0) {
            respond("Username already exists", "danger", "register");
            reload();
        }

        // Check password match
        if ($password !== $cpassword) {
            respond("Passwords don't match", "danger", "register");
            reload();
        }

        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $result = $db->run("INSERT INTO users (username, password) VALUES (:username, :password)", [':username' => $username, ':password' => $hash]);

        if ($result) {
            $userId = $db->run("SELECT id FROM users WHERE username = :username", [':username' => $username])->fetch();
            $this->loginUser($userId);

            reload();
        }
    }

    public function loginUser($userId) {
        $_SESSION['userId'] = $userId;

        $user = $this->db->run("SELECT username FROM users WHERE id = :id",['id' => $userId])->fetch();

        $_SESSION['username'] = $user->username;
        $_SESSION['loggedIn'] = true;
    }

    public function handleLogout() {
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['userId']);

        reload();
    }

    public function validate($data) {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}