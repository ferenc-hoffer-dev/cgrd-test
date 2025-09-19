<?php

namespace App\Controller;

use App\Service\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(): void
    {
        if ($this->authService->check()) {
            $this->authService->redirect('/news');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$username, $password] = $this->getLoginCredentials();
            if ($this->authService->attempt($username, $password)) {
                $this->authService->redirect('/news');
                return;
            }

            $error = "Wrong Login Data!";

        }

        include __DIR__ . '/../../public/login.php';
    }

    public function logout(): void
    {
        $this->authService->logout();
        $this->authService->redirect('/login');
    }

    private function getLoginCredentials(): array
    {
        return [
            $_POST['username'] ?? '',
            $_POST['password'] ?? '',
        ];
    }
}
