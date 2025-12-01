<?php
namespace App\Core;

class Csrf
{
    public static function token(): string
    {
        if (!Session::get('_csrf_token')) {
            Session::set('_csrf_token', bin2hex(random_bytes(16)));
        }
        return Session::get('_csrf_token');
    }

    public static function validate(string $token): bool
    {
        $stored = Session::get('_csrf_token');
        return hash_equals($stored ?? '', $token);
    }
}
