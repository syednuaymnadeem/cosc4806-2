<?php

require_once('database.php');

class User {

    public function get_all_users() {
        $db = db_connect();
        $stmt = $db->prepare("SELECT username FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function username_exists($username) {
        $db = db_connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch() !== false;
    }

    public function create_user($username, $password) {
        $db = db_connect();

        if ($this->username_exists($username)) {
            return "Username already exists.";
        }

        // Simplified password rule
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters long.";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password
        ]);

        return true;
    }


    public function login($username, $password) {
        $db = db_connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && password_verify($password, $user['password']);
    }
}
?>
