<?php

namespace Core;

class Session
{
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function start(): void
    {
        session_start();
    }

    public static function destroy(): void
    {
        // This will delete the session cookie
        $params = session_get_cookie_params();
        setcookie(
            (string) session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );

        session_destroy();
    }

    public static function regenerate(): void
    {
        if (session_id()) {
            session_regenerate_id(true);
        }
    }

    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash'] ??= [];
        if (is_array($_SESSION['_flash'])) {
            $_SESSION['_flash'][$key] = $value;
        }
    }

    /**
     * @return array<string,mixed>
     */
    public static function get_flash(): array
    {
        $flash = self::get('_flash', []);
        if (is_array($flash)) {
            /** @var array<string,mixed> */
            return $flash;
        }

        return [];
    }

    public static function unflash(): void
    {
        if (isset($_SESSION['_flash'])) {
            unset($_SESSION['_flash']);
        }
    }
}
