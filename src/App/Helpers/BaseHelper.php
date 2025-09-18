<?php

namespace App\Helpers;

class BaseHelper
{
    public static function isUserSet(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function getUser(): ?string
    {
        return $_SESSION['user'] ?? null;
    }

    public static function logout(): void
    {
        session_destroy();
    }
}
