<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }

        $this->view('auth/login', ['csrf' => Csrf::token()], 'auth');
    }

    public function login(): void
    {
        $token = $_POST['_token'] ?? '';
        $errors = [];
        if (!Csrf::validate($token)) {
            $errors['general'] = 'Token inválido. Por favor, recarga la página.';
        }

        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        if ($email === '' || $password === '') {
            $errors['general'] = 'Por favor ingresa tu usuario y contraseña.';
        }

        if (!$errors) {
            $userModel = new User();
            $user = $userModel->findByEmailOrUsername($email);

            if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors['general'] = 'Credenciales incorrectas.';
            } elseif ((int)$user['status'] !== 1) {
                $errors['general'] = 'Usuario inactivo.';
            } else {
                Auth::attempt($email, $password);
                if ($remember) {
                    Auth::remember((int)$user['id']);
                }
                $this->redirect('/dashboard');
                return;
            }
        }

        $this->view('auth/login', [
            'error' => $errors['general'] ?? null,
            'csrf' => Csrf::token(),
            'email' => Helper::e($email),
        ], 'auth');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
