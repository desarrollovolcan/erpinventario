<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login', ['csrf' => Csrf::token()]);
    }

    public function login(): void
    {
        $token = $_POST['_token'] ?? '';
        if (!Csrf::validate($token)) {
            http_response_code(400);
            echo 'Token inválido';
            return;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
        $password = $_POST['password'] ?? '';
        if (Auth::attempt($email, $password)) {
            $this->redirect('/');
            return;
        }
        $this->view('auth/login', [
            'error' => 'Credenciales inválidas',
            'csrf' => Csrf::token(),
            'email' => Helper::e($email),
        ]);
    }

    public function logout(): void
    {
        Session::destroy();
        $this->redirect('/login');
    }
}
