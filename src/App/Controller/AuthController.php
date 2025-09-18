<?php

namespace App\Controller;

use App\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(): void
    {
        if ($this->authService->check()) {
            $this->authService->redirect('/news');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if ($this->authService->attempt($username, $password)) {
                $this->authService->redirect('/news');
            } else {
                $error = "Invalid username or password";
            }
        }

        include __DIR__ . '/../../public/login.php';
    }
}
