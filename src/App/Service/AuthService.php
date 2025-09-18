<?php

namespace App;

use PDO;

class AuthService
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function attempt(string $username, string $password): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
        $stmt->execute(['u' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            return true;
        }
        return false;
    }

    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public function user(): ?string
    {
        return $_SESSION['user'] ?? null;
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
