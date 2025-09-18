<?php
namespace App\Controller;

use App\Auth;
use PDO;

abstract class BaseController {
    protected PDO $pdo;
    protected Auth $auth;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->auth = new Auth($pdo);
    }

    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    protected function isAuthenticated(): bool {
        return $this->auth::check();
    }

    protected function getCurrentUser(): ?string {
        return $this->auth::user();
    }
}
