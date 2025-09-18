<?php
namespace App\Controller;

use App\Auth;

class LoginController {
    private $db;
    private $auth;

    public function __construct($db) {
        $this->db = $db;
        $this->auth = new Auth($db);
    }

    public function handle() {
        if ($this->auth::check()) {
            header('Location: /news');
            exit;
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if ($this->auth->attempt($username, $password)) {
                header('Location: /news');
                exit;
            } else {
                $error = "Hibás felhasználónév vagy jelszó";
            }
        }

        include __DIR__ . '/../../public/login.php';
    }
}
