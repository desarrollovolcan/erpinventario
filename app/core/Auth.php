<?php
namespace App\Core;

use App\Models\User;

class Auth
{
    public static function user(): ?array
    {
        $user = Session::get('user');
        if (!$user) {
            $user = self::attemptRemember();
        }

        return $user;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function attempt(string $email, string $password): bool
    {
        $userModel = new User();
        $user = $userModel->findByEmailOrUsername($email);
        if ($user && (int)$user['status'] === 1 && password_verify($password, $user['password_hash'])) {
            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role_slug' => $user['role_slug'],
                'role_name' => $user['role_name'],
            ]);
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        Session::destroy();
        $config = require __DIR__ . '/../../config/config.php';
        setcookie($config['remember_cookie_name'], '', time() - 3600, '/', '', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', true);
    }

    public static function requireRole(array $roles): void
    {
        $user = self::user();
        if (!$user || !in_array($user['role_slug'], $roles, true)) {
            http_response_code(403);
            echo 'Acceso denegado';
            exit;
        }
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function hasRole(array|string $roles): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }
        $rolesArray = is_array($roles) ? $roles : [$roles];
        return in_array($user['role_slug'], $rolesArray, true);
    }

    public static function remember(int $userId): void
    {
        $config = require __DIR__ . '/../../config/config.php';
        $secret = $config['app_key'];
        $signature = hash_hmac('sha256', (string)$userId, $secret);
        $token = base64_encode($userId . '|' . $signature);
        setcookie(
            $config['remember_cookie_name'],
            $token,
            [
                'expires' => time() + 60 * 60 * 24 * 30,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
    }

    private static function attemptRemember(): ?array
    {
        $config = require __DIR__ . '/../../config/config.php';
        $cookie = $_COOKIE[$config['remember_cookie_name']] ?? null;
        if (!$cookie) {
            return null;
        }

        $decoded = base64_decode($cookie, true);
        if (!$decoded || !str_contains($decoded, '|')) {
            return null;
        }

        [$userId, $signature] = explode('|', $decoded, 2);
        $expected = hash_hmac('sha256', (string)$userId, $config['app_key']);
        if (!hash_equals($expected, $signature)) {
            return null;
        }

        $userModel = new User();
        $user = $userModel->findActiveById((int)$userId);
        if ($user) {
            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role_slug' => $user['role_slug'],
                'role_name' => $user['role_name'],
            ]);
            return Session::get('user');
        }

        return null;
    }
}
