<?php

class Auth
{
    public static function login(array $user): void
    {
        $_SESSION['auth'] = [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];
    }

    public static function logout(): void
    {
        unset($_SESSION['auth']);
    }

    public static function check(): bool
    {
        return isset($_SESSION['auth']['id']);
    }

    public static function id(): ?int
    {
        return self::check() ? (int) $_SESSION['auth']['id'] : null;
    }

    public static function user(): ?array
    {
        return $_SESSION['auth'] ?? null;
    }
}