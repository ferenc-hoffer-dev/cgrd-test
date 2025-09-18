<?php
namespace App\Controller;

class LoginController extends BaseController {

    public function handle(): void {
        if ($this->isAuthenticated()) {
            $this->redirect('/news');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if ($this->auth->attempt($username, $password)) {
                $this->redirect('/news');
            } else {
                $error = "Invalid username or password";
            }
        }

        include __DIR__ . '/../../public/login.php';
    }
}
